@extends('layouts.editor')

@section('title', 'Template Editor')

@push('styles')
<style>
    /* Editor-specific styles */
    #editor-container {
        height: 100%;
        overflow: hidden;
    }

    /* Sidebar - Components */
    .components-sidebar {
        width: 280px;
        border-right: 1px solid #e5e7eb;
        overflow-y: auto;
    }

    .component-item {
        cursor: grab;
        transition: all 0.2s;
    }

    .component-item:hover {
        background: #fef3c7;
        border-color: #d4af37;
    }

    .component-item:active {
        cursor: grabbing;
    }

    /* Canvas - Preview Area */
    .canvas-area {
        flex: 1;
        overflow-y: auto;
        background: #f3f4f6;
        padding: 24px;
    }

    #editor-canvas {
        margin: 0 auto;
        background: white;
        min-height: 600px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: max-width 0.3s ease;
    }

    /* Viewport sizes */
    .viewport-desktop {
        max-width: 100%;
    }

    .viewport-tablet {
        max-width: 768px;
    }

    .viewport-mobile {
        max-width: 375px;
    }

    /* Section wrapper for drag-drop */
    .section-wrapper {
        position: relative;
        border: 2px solid transparent;
        transition: all 0.2s;
    }

    .section-wrapper:hover {
        border-color: #d4af37;
    }

    .section-wrapper.selected {
        border-color: #d4af37;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
    }

    .section-actions {
        position: absolute;
        top: -14px;
        right: 8px;
        display: none;
        gap: 4px;
    }

    .section-wrapper:hover .section-actions,
    .section-wrapper.selected .section-actions {
        display: flex;
    }

    /* Drag and drop */
    .sortable-ghost {
        opacity: 0.4;
        background: #e5e7eb;
        border: 2px dashed #9ca3af;
    }

    .sortable-drag {
        opacity: 0.8;
    }

    .drop-indicator {
        height: 4px;
        background: #d4af37;
        margin: 8px 0;
        border-radius: 2px;
    }

    /* Properties Panel */
    .properties-panel {
        width: 320px;
        border-left: 1px solid #e5e7eb;
        overflow-y: auto;
    }

    .property-tab {
        transition: all 0.2s;
    }

    .property-tab.active {
        border-bottom: 2px solid #d4af37;
        color: #d4af37;
    }

    /* Empty state */
    .empty-canvas {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        color: #9ca3af;
    }

    /* Header toolbar */
    .editor-toolbar {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 24px;
    }

    .viewport-btn {
        transition: all 0.2s;
    }

    .viewport-btn.active {
        background: #d4af37;
        color: white;
    }

    /* Media picker */
    .media-picker-item {
        cursor: pointer;
        transition: all 0.2s;
    }

    .media-picker-item:hover {
        border-color: #d4af37;
    }

    .media-picker-item.selected {
        border-color: #d4af37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.3);
    }

    /* Loading states */
    .saving-indicator {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Hide scrollbar but keep functionality */
    .components-sidebar::-webkit-scrollbar,
    .properties-panel::-webkit-scrollbar,
    .canvas-area::-webkit-scrollbar {
        width: 6px;
    }

    .components-sidebar::-webkit-scrollbar-thumb,
    .properties-panel::-webkit-scrollbar-thumb,
    .canvas-area::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }
</style>
@endpush

@push('header-actions')
<!-- Save Status -->
<span x-show="saving" class="text-sm text-gray-500 saving-indicator">Saving...</span>
<span x-show="lastSaved && !saving" class="text-sm text-gray-500">Last saved: <span x-text="formatTime(lastSaved)"></span></span>

<!-- Publish Button -->
<button @click="publish()" :disabled="templateData?.is_active"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition text-sm font-medium"
        :class="templateData?.is_active ? 'bg-green-500 text-white' : 'bg-black text-white hover:bg-gray-800'">
    <span x-text="templateData?.is_active ? 'Active' : 'Publish'"></span>
</button>
@endpush

@section('content')
<script>
    window.templateId = {{ $template->id ?? 0 }};
</script>

<div x-data="templateEditor()" x-init="init()" class="h-full flex">
    <!-- Editor Container -->
    <div id="editor-container" class="flex flex-1 overflow-hidden">
        <!-- Left Sidebar - Components -->
        <div class="components-sidebar bg-white">
            <div class="p-4 border-b sticky top-0 bg-white z-10">
                <h2 class="font-semibold text-gray-900">Components</h2>
                <p class="text-xs text-gray-500 mt-1">Click to add</p>
            </div>
            <div class="p-3 space-y-2">
                <template x-for="(category, categoryKey) in componentCategories" :key="categoryKey">
                    <div x-data="{ open: categoryKey === 'basic' }" class="border border-gray-200 rounded-lg overflow-hidden">
                        <!-- Category Header -->
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="categoryKey === 'basic'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    <path x-show="categoryKey === 'countdown'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <path x-show="categoryKey === 'rsvp'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    <path x-show="categoryKey === 'media'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    <path x-show="categoryKey === 'elements'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span class="font-medium text-sm text-gray-900" x-text="category.name"></span>
                                <span class="text-xs text-gray-500" x-text="'(' + category.components.length + ')'"></span>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Category Items -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="p-2 space-y-1">
                            <template x-for="componentType in category.components" :key="componentType">
                                <div x-show="window.componentSchemas[componentType]"
                                     class="component-item flex items-center gap-3 p-2 rounded-lg hover:bg-yellow-50 cursor-pointer transition"
                                     @click="$root.addComponent(componentType)">
                                    <div class="w-8 h-8 rounded bg-yellow-50 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <!-- Icons for different components -->
                                            <path x-show="componentType === 'hero'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            <path x-show="componentType === 'text'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                            <path x-show="componentType.includes('countdown')" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            <path x-show="componentType.includes('rsvp')" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            <path x-show="componentType === 'image'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            <path x-show="componentType === 'video'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            <path x-show="componentType === 'gallery'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            <path x-show="componentType === 'map'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path x-show="componentType === 'music'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                            <path x-show="componentType === 'button'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                            <path x-show="componentType === 'divider'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-sm text-gray-900 truncate" x-text="window.componentSchemas[componentType]?.name"></p>
                                        <p class="text-xs text-gray-500 truncate" x-text="componentType"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Center - Canvas -->
        <div class="canvas-area">
            <div x-show="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-yellow-500"></div>
                <p class="mt-4 text-gray-600">Loading editor...</p>
            </div>

            <div x-show="!loading && sections.length === 0" class="empty-canvas">
                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Start Building</h3>
                <p class="text-gray-500 mb-4">Drag components from the sidebar or click to add</p>
            </div>

            <div id="editor-canvas" x-show="!loading && sections.length > 0"
                 :class="'viewport-' + currentViewport">
                <template x-for="(section, index) in sections" :key="section.id">
                    <div class="section-wrapper"
                         :class="{ 'selected': selectedSection?.id === section.id }"
                         @click="selectSection(section)">
                        <!-- Section actions -->
                        <div class="section-actions">
                            <button @click.stop="moveSection(index, -1)"
                                    x-show="index > 0"
                                    class="p-1.5 bg-white rounded shadow hover:bg-gray-50"
                                    title="Move up">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                </svg>
                            </button>
                            <button @click.stop="moveSection(index, 1)"
                                    x-show="index < sections.length - 1"
                                    class="p-1.5 bg-white rounded shadow hover:bg-gray-50"
                                    title="Move down">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <button @click.stop="duplicateSection(section)"
                                    class="p-1.5 bg-white rounded shadow hover:bg-gray-50"
                                    title="Duplicate">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                            <button @click.stop="confirmDeleteSection(section)"
                                    class="p-1.5 bg-red-500 text-white rounded shadow hover:bg-red-600"
                                    title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Section preview -->
                        <div class="section-preview">
                            <div class="p-4 text-center text-gray-500">
                                <p class="font-medium" x-text="componentSchemas[section.section_type]?.name || section.section_type"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Right - Properties Panel -->
        <div class="properties-panel bg-white">
            <div x-show="!selectedSection" class="p-6 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <p>Select a section to edit its properties</p>
            </div>

            <div x-show="selectedSection">
                <!-- Tabs -->
                <div class="flex border-b sticky top-0 bg-white z-10">
                    <template x-for="tab in (componentSchemas[selectedSection?.section_type]?.tabs || ['Settings'])" :key="tab">
                        <button @click="currentTab = tab"
                                :class="{ 'active': currentTab === tab }"
                                class="property-tab flex-1 px-4 py-3 text-sm font-medium"
                                x-text="tab">
                        </button>
                    </template>
                </div>

                <!-- Properties -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-4" x-text="componentSchemas[selectedSection?.section_type]?.name"></h3>

                    <!-- Dynamic properties will be rendered here -->
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">Properties panel content will be dynamically rendered based on component schema.</p>
                        <pre class="text-xs bg-gray-50 p-3 rounded overflow-auto max-h-96" x-text="JSON.stringify(selectedSection?.props, null, 2)"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
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
                await fetch('/admin/api/sections/reorder', {
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
            try {
                await fetch('/admin/api/sections', {
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
                this.lastSaved = new Date();
            } catch (error) {
                console.error('Error saving:', error);
                Swal.fire('Error', 'Failed to save changes', 'error');
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
</script>
@endsection
