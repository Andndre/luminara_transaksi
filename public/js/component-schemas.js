// Component Schemas for Visual Invitation Editor
// Each schema defines the properties that can be configured for each component type

const componentSchemas = {
    hero: {
        name: 'Hero Section',
        icon: 'hero',
        tabs: ['Content', 'Style', 'Animation'],
        fields: {
            background: {
                type: 'media',
                accept: 'image,video',
                label: 'Background'
            },
            title: {
                type: 'text',
                label: 'Title Text',
                default: 'The Wedding Of'
            },
            groom_name: {
                type: 'text',
                label: 'Groom Name'
            },
            bride_name: {
                type: 'text',
                label: 'Bride Name'
            },
            event_date: {
                type: 'date',
                label: 'Event Date'
            },
            overlay_color: {
                type: 'color',
                label: 'Overlay Color',
                default: '#000000'
            },
            overlay_opacity: {
                type: 'slider',
                label: 'Overlay Opacity',
                min: 0,
                max: 100,
                default: 40
            },
            font_family: {
                type: 'select',
                label: 'Font Family',
                options: [
                    { value: 'Playfair Display', label: 'Playfair Display' },
                    { value: 'Great Vibes', label: 'Great Vibes' },
                    { value: 'Lato', label: 'Lato' },
                    { value: 'Montserrat', label: 'Montserrat' },
                    { value: 'Open Sans', label: 'Open Sans' }
                ],
                default: 'Playfair Display'
            },
            text_color: {
                type: 'color',
                label: 'Text Color',
                default: '#ffffff'
            },
            alignment: {
                type: 'radio-icon',
                label: 'Alignment',
                options: ['left', 'center', 'right'],
                default: 'center'
            },
            padding_top: {
                type: 'slider',
                label: 'Padding Top',
                min: 0,
                max: 200,
                unit: 'px',
                default: 120
            },
            padding_bottom: {
                type: 'slider',
                label: 'Padding Bottom',
                min: 0,
                max: 200,
                unit: 'px',
                default: 120
            }
        }
    },

    text: {
        name: 'Text Block',
        icon: 'text',
        tabs: ['Content', 'Typography'],
        fields: {
            content: {
                type: 'textarea',
                label: 'Content',
                default: 'Add your text content here...'
            },
            font_family: {
                type: 'select',
                label: 'Font Family',
                options: [
                    { value: 'Playfair Display', label: 'Playfair Display' },
                    { value: 'Great Vibes', label: 'Great Vibes' },
                    { value: 'Lato', label: 'Lato' },
                    { value: 'Montserrat', label: 'Montserrat' },
                    { value: 'Open Sans', label: 'Open Sans' }
                ],
                default: 'Lato'
            },
            font_size: {
                type: 'slider',
                label: 'Font Size',
                min: 12,
                max: 72,
                unit: 'px',
                default: 16
            },
            font_weight: {
                type: 'select',
                label: 'Font Weight',
                options: [
                    { value: '300', label: 'Light' },
                    { value: '400', label: 'Normal' },
                    { value: '500', label: 'Medium' },
                    { value: '600', label: 'Semi Bold' },
                    { value: '700', label: 'Bold' }
                ],
                default: '400'
            },
            color: {
                type: 'color',
                label: 'Text Color',
                default: '#333333'
            },
            alignment: {
                type: 'radio-icon',
                label: 'Alignment',
                options: ['left', 'center', 'right'],
                default: 'left'
            },
            max_width: {
                type: 'slider',
                label: 'Max Width',
                min: 100,
                max: 1200,
                unit: 'px',
                default: 800
            }
        }
    },

    countdown: {
        name: 'Countdown Timer',
        icon: 'clock',
        tabs: ['Settings', 'Style'],
        fields: {
            target_date: {
                type: 'datetime',
                label: 'Target Date & Time'
            },
            title: {
                type: 'text',
                label: 'Title',
                default: 'Counting Down To'
            },
            theme: {
                type: 'select',
                label: 'Theme',
                options: [
                    { value: 'classic', label: 'Classic' },
                    { value: 'modern', label: 'Modern' },
                    { value: 'elegant', label: 'Elegant' },
                    { value: 'minimal', label: 'Minimal' }
                ],
                default: 'elegant'
            },
            background_color: {
                type: 'color',
                label: 'Background Color',
                default: '#f8f9fa'
            },
            text_color: {
                type: 'color',
                label: 'Text Color',
                default: '#212529'
            },
            accent_color: {
                type: 'color',
                label: 'Accent Color',
                default: '#d4af37'
            },
            padding_top: {
                type: 'slider',
                label: 'Padding Top',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            },
            padding_bottom: {
                type: 'slider',
                label: 'Padding Bottom',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            }
        }
    },

    rsvp: {
        name: 'RSVP Form',
        icon: 'form',
        tabs: ['Fields', 'Button', 'Settings'],
        fields: {
            title: {
                type: 'text',
                label: 'Form Title',
                default: 'RSVP'
            },
            subtitle: {
                type: 'text',
                label: 'Subtitle',
                default: 'Please confirm your attendance'
            },
            button_text: {
                type: 'text',
                label: 'Button Text',
                default: 'Kirim Konfirmasi'
            },
            button_color: {
                type: 'color',
                label: 'Button Color',
                default: '#d4af37'
            },
            success_message: {
                type: 'textarea',
                label: 'Success Message',
                default: 'Terima kasih atas konfirmasi Anda!'
            },
            whatsapp_enabled: {
                type: 'boolean',
                label: 'Forward to WhatsApp',
                default: false
            },
            whatsapp_phone: {
                type: 'text',
                label: 'WhatsApp Number',
                placeholder: '628123456789'
            },
            background_color: {
                type: 'color',
                label: 'Background Color',
                default: '#ffffff'
            },
            padding_top: {
                type: 'slider',
                label: 'Padding Top',
                min: 0,
                max: 150,
                unit: 'px',
                default: 80
            },
            padding_bottom: {
                type: 'slider',
                label: 'Padding Bottom',
                min: 0,
                max: 150,
                unit: 'px',
                default: 80
            }
        }
    },

    image: {
        name: 'Image',
        icon: 'image',
        tabs: ['Image', 'Style'],
        fields: {
            src: {
                type: 'media',
                accept: 'image',
                label: 'Image'
            },
            alt: {
                type: 'text',
                label: 'Alt Text',
                default: ''
            },
            width: {
                type: 'slider',
                label: 'Width',
                min: 10,
                max: 100,
                unit: '%',
                default: 100
            },
            border_radius: {
                type: 'slider',
                label: 'Border Radius',
                min: 0,
                max: 50,
                unit: 'px',
                default: 0
            },
            shadow: {
                type: 'boolean',
                label: 'Drop Shadow',
                default: false
            },
            alignment: {
                type: 'radio-icon',
                label: 'Alignment',
                options: ['left', 'center', 'right'],
                default: 'center'
            },
            margin_top: {
                type: 'slider',
                label: 'Margin Top',
                min: 0,
                max: 100,
                unit: 'px',
                default: 0
            },
            margin_bottom: {
                type: 'slider',
                label: 'Margin Bottom',
                min: 0,
                max: 100,
                unit: 'px',
                default: 24
            }
        }
    },

    video: {
        name: 'Video',
        icon: 'video',
        tabs: ['Video', 'Settings'],
        fields: {
            type: {
                type: 'radio',
                label: 'Video Type',
                options: [
                    { value: 'upload', label: 'Upload Video' },
                    { value: 'youtube', label: 'YouTube' }
                ],
                default: 'upload'
            },
            src: {
                type: 'media',
                accept: 'video',
                label: 'Video File'
            },
            youtube_url: {
                type: 'text',
                label: 'YouTube URL',
                placeholder: 'https://youtube.com/watch?v=...'
            },
            autoplay: {
                type: 'boolean',
                label: 'Autoplay',
                default: false
            },
            muted: {
                type: 'boolean',
                label: 'Muted',
                default: true
            },
            controls: {
                type: 'boolean',
                label: 'Show Controls',
                default: true
            },
            width: {
                type: 'slider',
                label: 'Width',
                min: 10,
                max: 100,
                unit: '%',
                default: 100
            },
            margin_top: {
                type: 'slider',
                label: 'Margin Top',
                min: 0,
                max: 100,
                unit: 'px',
                default: 0
            },
            margin_bottom: {
                type: 'slider',
                label: 'Margin Bottom',
                min: 0,
                max: 100,
                unit: 'px',
                default: 24
            }
        }
    },

    gallery: {
        name: 'Photo Gallery',
        icon: 'gallery',
        tabs: ['Images', 'Layout'],
        fields: {
            images: {
                type: 'media-multiple',
                accept: 'image',
                label: 'Images',
                default: []
            },
            title: {
                type: 'text',
                label: 'Gallery Title',
                default: 'Our Moments'
            },
            layout: {
                type: 'radio',
                label: 'Layout',
                options: [
                    { value: 'grid', label: 'Grid' },
                    { value: 'masonry', label: 'Masonry' },
                    { value: 'slider', label: 'Slider' }
                ],
                default: 'grid'
            },
            columns: {
                type: 'slider',
                label: 'Columns (Grid)',
                min: 1,
                max: 4,
                default: 3
            },
            gap: {
                type: 'slider',
                label: 'Gap',
                min: 0,
                max: 50,
                unit: 'px',
                default: 16
            },
            lightbox: {
                type: 'boolean',
                label: 'Enable Lightbox',
                default: true
            },
            padding_top: {
                type: 'slider',
                label: 'Padding Top',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            },
            padding_bottom: {
                type: 'slider',
                label: 'Padding Bottom',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            }
        }
    },

    map: {
        name: 'Google Maps',
        icon: 'map',
        tabs: ['Map', 'Style'],
        fields: {
            title: {
                type: 'text',
                label: 'Section Title',
                default: 'Venue Location'
            },
            address: {
                type: 'text',
                label: 'Address'
            },
            latitude: {
                type: 'text',
                label: 'Latitude'
            },
            longitude: {
                type: 'text',
                label: 'Longitude'
            },
            zoom: {
                type: 'slider',
                label: 'Zoom Level',
                min: 1,
                max: 20,
                default: 15
            },
            height: {
                type: 'slider',
                label: 'Height',
                min: 200,
                max: 600,
                unit: 'px',
                default: 400
            },
            show_button: {
                type: 'boolean',
                label: 'Show Directions Button',
                default: true
            },
            button_text: {
                type: 'text',
                label: 'Button Text',
                default: 'Get Directions'
            },
            padding_top: {
                type: 'slider',
                label: 'Padding Top',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            },
            padding_bottom: {
                type: 'slider',
                label: 'Padding Bottom',
                min: 0,
                max: 150,
                unit: 'px',
                default: 64
            }
        }
    },

    music: {
        name: 'Background Music',
        icon: 'music',
        tabs: ['Audio', 'Controls'],
        fields: {
            src: {
                type: 'media',
                accept: 'audio',
                label: 'Audio File'
            },
            autoplay: {
                type: 'boolean',
                label: 'Autoplay',
                default: true
            },
            loop: {
                type: 'boolean',
                label: 'Loop',
                default: true
            },
            show_controls: {
                type: 'boolean',
                label: 'Show Controls',
                default: true
            },
            volume: {
                type: 'slider',
                label: 'Volume',
                min: 0,
                max: 100,
                default: 50
            }
        }
    },

    button: {
        name: 'Button',
        icon: 'button',
        tabs: ['Button', 'Style'],
        fields: {
            text: {
                type: 'text',
                label: 'Button Text',
                default: 'Click Me'
            },
            link_type: {
                type: 'radio',
                label: 'Link Type',
                options: [
                    { value: 'url', label: 'URL' },
                    { value: 'section', label: 'Section Anchor' },
                    { value: 'tel', label: 'Phone' },
                    { value: 'mailto', label: 'Email' }
                ],
                default: 'url'
            },
            url: {
                type: 'text',
                label: 'URL',
                placeholder: 'https://...'
            },
            style: {
                type: 'select',
                label: 'Button Style',
                options: [
                    { value: 'primary', label: 'Primary' },
                    { value: 'secondary', label: 'Secondary' },
                    { value: 'outline', label: 'Outline' },
                    { value: 'ghost', label: 'Ghost' }
                ],
                default: 'primary'
            },
            size: {
                type: 'radio',
                label: 'Size',
                options: [
                    { value: 'small', label: 'Small' },
                    { value: 'medium', label: 'Medium' },
                    { value: 'large', label: 'Large' }
                ],
                default: 'medium'
            },
            alignment: {
                type: 'radio-icon',
                label: 'Alignment',
                options: ['left', 'center', 'right'],
                default: 'center'
            },
            background_color: {
                type: 'color',
                label: 'Background Color',
                default: '#d4af37'
            },
            text_color: {
                type: 'color',
                label: 'Text Color',
                default: '#ffffff'
            },
            border_radius: {
                type: 'slider',
                label: 'Border Radius',
                min: 0,
                max: 50,
                unit: 'px',
                default: 8
            },
            margin_top: {
                type: 'slider',
                label: 'Margin Top',
                min: 0,
                max: 100,
                unit: 'px',
                default: 0
            },
            margin_bottom: {
                type: 'slider',
                label: 'Margin Bottom',
                min: 0,
                max: 100,
                unit: 'px',
                default: 24
            }
        }
    },

    divider: {
        name: 'Divider/Spacer',
        icon: 'divider',
        tabs: ['Style'],
        fields: {
            type: {
                type: 'radio',
                label: 'Type',
                options: [
                    { value: 'line', label: 'Line' },
                    { value: 'space', label: 'Space Only' }
                ],
                default: 'line'
            },
            height: {
                type: 'slider',
                label: 'Height',
                min: 10,
                max: 200,
                unit: 'px',
                default: 50
            },
            color: {
                type: 'color',
                label: 'Line Color',
                default: '#e5e7eb'
            },
            style: {
                type: 'select',
                label: 'Line Style',
                options: [
                    { value: 'solid', label: 'Solid' },
                    { value: 'dashed', label: 'Dashed' },
                    { value: 'dotted', label: 'Dotted' }
                ],
                default: 'solid'
            },
            width: {
                type: 'slider',
                label: 'Line Width',
                min: 10,
                max: 100,
                unit: '%',
                default: 100
            }
        }
    }
};
