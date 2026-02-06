// Component Schemas for Visual Invitation Editor
// Simplified version - only text component for now

// Component categories
const componentCategories = {
    basic: {
        name: 'Basic',
        icon: 'square',
        components: ['text']
    }
};

const componentSchemas = {
    text: {
        name: 'Text Block',
        description: 'Heading or paragraph text',
        icon: 'type',
        fields: {
            content: {
                type: 'textarea',
                label: 'Content',
                default: 'Tulis teks anda di sini...'
            },
            tag: {
                type: 'select',
                label: 'HTML Tag',
                options: [
                    { value: 'p', label: 'Paragraph' },
                    { value: 'h1', label: 'Heading 1' },
                    { value: 'h2', label: 'Heading 2' },
                    { value: 'h3', label: 'Heading 3' },
                    { value: 'h4', label: 'Heading 4' },
                    { value: 'h5', label: 'Heading 5' },
                    { value: 'h6', label: 'Heading 6' }
                ],
                default: 'p'
            },
            align: {
                type: 'select',
                label: 'Alignment',
                options: [
                    { value: 'left', label: 'Left' },
                    { value: 'center', label: 'Center' },
                    { value: 'right', label: 'Right' }
                ],
                default: 'left'
            }
        }
    }
};

// Export to window for Alpine.js access
window.componentCategories = componentCategories;
window.componentSchemas = componentSchemas;
