// Template Editor Alpine.js Component
function templateEditor() {
    return {
        templateId: window.templateId,
        templateData: null,
        sections: [],
        selectedSection: null,
        currentViewport: 'desktop',
        currentTab: 'Settings',
        loading: true,
        saving: false,
        lastSaved: null,
        componentSchemas: window.componentSchemas || {},
        saveTimeout: null,
        currentMediaPickerProperty: null,

        async init() {
            await this.loadTemplateData();
            this.initSortable();

            // Store reference to addComponent for global access
            window.templateEditorAddComponent = (type) => this.addComponent(type);

            // Listen for save event from layout
            window.addEventListener('editor-save', () => {
                this.saveSections();
            });
        },

        async loadTemplateData() {
            try {
                const response = await fetch(`/admin/api/templates/${this.templateId}/load`);
                const data = await response.json();
                this.templateData = data.template;
                this.sections = data.sections || [];
            } catch (error) {
                console.error('Error loading template:', error);
                Swal.fire('Error', 'Failed to load template data', 'error');
            } finally {
                this.loading = false;
            }
        },

        initSortable() {
            const canvas = document.getElementById('editor-canvas');
            if (!canvas) return;

            new Sortable(canvas, {
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: (evt) => {
                    this.reorderSections();
                }
            });
        },

        setViewport(size) {
            this.currentViewport = size;
        },

        async addComponent(type) {
            const schema = this.componentSchemas[type];
            if (!schema) return;

            const newSection = {
                id: 'temp-' + Date.now(),
                section_type: type,
                props: this.getDefaultProps(schema),
                order_index: this.sections.length
            };

            this.sections.push(newSection);
            this.selectedSection = newSection;
            await this.saveSections();
        },

        getDefaultProps(schema) {
            const props = {};
            if (schema.fields) {
                for (const [key, field] of Object.entries(schema.fields)) {
                    if (field.default !== undefined) {
                        props[key] = field.default;
                    }
                }
            }
            return props;
        },

        selectSection(section) {
            this.selectedSection = section;
            const schema = this.componentSchemas[section.section_type];
            if (schema && schema.tabs) {
                this.currentTab = schema.tabs[0];
            }
        },

        updateProp(key, value) {
            if (!this.selectedSection) return;
            // Using $set to ensure Alpine reactivity
            this.selectedSection.props = {
                ...this.selectedSection.props,
                [key]: value
            };
        },

        async confirmDeleteSection(section) {
            const result = await Swal.fire({
                title: 'Delete this section?',
                text: 'This action cannot be undone',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            });

            if (result.isConfirmed) {
                await this.deleteSection(section.id);
            }
        },

        async deleteSection(sectionId) {
            this.sections = this.sections.filter(s => s.id !== sectionId);
            if (this.selectedSection?.id === sectionId) {
                this.selectedSection = null;
            }
            await this.saveSections();
        },

        async duplicateSection(section) {
            const duplicated = {
                ...section,
                id: 'temp-' + Date.now(),
                order_index: this.sections.length
            };
            this.sections.push(duplicated);
            this.selectedSection = duplicated;
            await this.saveSections();
        },

        async moveSection(index, direction) {
            const newIndex = index + direction;
            if (newIndex < 0 || newIndex >= this.sections.length) return;

            const temp = this.sections[index];
            this.sections[index] = this.sections[newIndex];
            this.sections[newIndex] = temp;

            await this.reorderSections();
        },

        async reorderSections() {
            const newOrder = this.sections.map((s, index) => ({
                id: s.id,
                order_index: index
            }));

            try {
                await fetch('/admin/api/templates/sections/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ sections: newOrder })
                });
            } catch (error) {
                console.error('Error reordering:', error);
            }
        },

        async saveSections() {
            this.saving = true;
            const saveText = document.getElementById('save-text');
            if (saveText) saveText.textContent = 'Menyimpan...';

            try {
                const response = await fetch('/admin/api/templates/sections', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        template_id: this.templateId,
                        sections: this.sections
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.lastSaved = new Date();
                    if (saveText) {
                        saveText.textContent = 'Tersimpan!';
                        setTimeout(() => {
                            if (saveText) saveText.textContent = 'Simpan';
                        }, 2000);
                    }

                    // Update temp IDs with real IDs from server
                    if (data.sections) {
                        data.sections.forEach((savedSection) => {
                            const index = this.sections.findIndex(s => s.id === savedSection.temp_id);
                            if (index !== -1) {
                                this.sections[index].id = savedSection.id;
                            }
                        });
                    }
                } else {
                    throw new Error(data.message || 'Save failed');
                }
            } catch (error) {
                console.error('Error saving:', error);
                Swal.fire('Error', 'Gagal menyimpan perubahan', 'error');
                if (saveText) {
                    saveText.textContent = 'Gagal';
                    setTimeout(() => {
                        if (saveText) saveText.textContent = 'Simpan';
                    }, 2000);
                }
            } finally {
                this.saving = false;
            }
        },

        async publish() {
            try {
                const response = await fetch(`/admin/templates/${this.templateId}/publish`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    this.templateData.is_active = true;
                    Swal.fire('Published!', 'Template is now active.', 'success');
                }
            } catch (error) {
                console.error('Error publishing:', error);
                Swal.fire('Error', 'Failed to publish template', 'error');
            }
        },

        async saveAndClose() {
            await this.saveSections();
            window.location.href = '/admin/templates';
        },

        // Get fields for the current tab
        getFieldsForTab(tabName) {
            if (!this.selectedSection) return {};

            const schema = this.componentSchemas[this.selectedSection.section_type];
            if (!schema || !schema.fields) return {};

            // If no tabs defined or tab is "Settings", return all fields
            if (!schema.tabs || tabName === 'Settings') {
                return schema.fields;
            }

            // Filter fields based on tab (currently simple implementation)
            // In future, fields could have a 'tab' property
            return schema.fields;
        },

        // Update a single property with debounced save
        updateProperty(key, value) {
            if (!this.selectedSection) return;

            // Ensure props object exists
            if (!this.selectedSection.props) {
                this.selectedSection.props = {};
            }

            // Update the property
            this.selectedSection.props[key] = value;

            // Trigger debounced save
            this.debouncedSave();
        },

        // Debounced save to avoid excessive API calls
        debouncedSave() {
            clearTimeout(this.saveTimeout);
            this.saveTimeout = setTimeout(() => {
                this.saveSections();
            }, 1000);
        },

        formatTime(date) {
            if (!date) return '';
            return new Date(date).toLocaleTimeString();
        }
    };
}
