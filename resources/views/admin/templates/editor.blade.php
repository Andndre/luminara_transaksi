@extends('layouts.editor')

@section('title', 'Template Editor')

@push('styles')
<link href="{{ asset('css/admin/template-editor.css') }}" rel="stylesheet">
@endpush

@push('header-actions')
<!-- Unsaved Changes Indicator -->
<span x-show="hasUnsavedChanges && !saving" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-medium">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <span>Unsaved changes</span>
</span>

<!-- Saving Indicator -->
<span x-show="saving" class="text-sm text-gray-500 saving-indicator">Saving...</span>

<!-- Last Saved -->
<span x-show="lastSaved && !saving && !hasUnsavedChanges" class="text-sm text-gray-500">
    Last saved: <span x-text="formatTime(lastSaved)"></span>
</span>

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
                                     @click="window.templateEditorAddComponent(componentType)">
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

                        <!-- Section preview - Live rendering -->
                        <div class="section-preview bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Render component based on type -->
                            <template x-if="section.section_type === 'text'">
                                <div class="p-6">
                                    <template x-if="section.props?.tag === 'h1'">
                                        <h1 class="text-4xl font-bold" :class="'text-' + (section.props?.align || 'left')" style="font-family: 'Playfair Display', serif;" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h1>
                                    </template>
                                    <template x-if="section.props?.tag === 'h2'">
                                        <h2 class="text-3xl font-bold" :class="'text-' + (section.props?.align || 'left')" style="font-family: 'Playfair Display', serif;" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h2>
                                    </template>
                                    <template x-if="section.props?.tag === 'h3'">
                                        <h3 class="text-2xl font-semibold" :class="'text-' + (section.props?.align || 'left')" style="font-family: 'Playfair Display', serif;" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h3>
                                    </template>
                                    <template x-if="section.props?.tag === 'h4'">
                                        <h4 class="text-xl font-semibold" :class="'text-' + (section.props?.align || 'left')" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h4>
                                    </template>
                                    <template x-if="section.props?.tag === 'h5'">
                                        <h5 class="text-lg font-medium" :class="'text-' + (section.props?.align || 'left')" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h5>
                                    </template>
                                    <template x-if="section.props?.tag === 'h6'">
                                        <h6 class="text-base font-medium" :class="'text-' + (section.props?.align || 'left')" x-html="section.props?.content || 'Tulis teks anda di sini...'"></h6>
                                    </template>
                                    <template x-if="!section.props?.tag || section.props?.tag === 'p'">
                                        <p class="text-base leading-relaxed" :class="'text-' + (section.props?.align || 'left')" x-html="section.props?.content || 'Tulis teks anda di sini...'"></p>
                                    </template>
                                </div>
                            </template>
                            <template x-if="section.section_type !== 'text'">
                                <div class="p-4 text-center text-gray-500">
                                    <p class="font-medium" x-text="componentSchemas[section.section_type]?.name || section.section_type"></p>
                                </div>
                            </template>
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

                    <!-- Dynamic properties based on schema -->
                    <div class="space-y-4">
                        <template x-for="(field, fieldKey) in componentSchemas[selectedSection?.section_type]?.fields" :key="fieldKey">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" x-text="field.label"></label>

                                <!-- Text input -->
                                <template x-if="field.type === 'text'">
                                    <input type="text"
                                           :value="selectedSection?.props?.[fieldKey]"
                                           @input="updateProp(fieldKey, $event.target.value)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                </template>

                                <!-- Textarea -->
                                <template x-if="field.type === 'textarea'">
                                    <textarea rows="4"
                                              @input="updateProp(fieldKey, $event.target.value)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                              x-text="selectedSection?.props?.[fieldKey] || ''"></textarea>
                                </template>

                                <!-- Select dropdown -->
                                <template x-if="field.type === 'select'">
                                    <select :value="selectedSection?.props?.[fieldKey]"
                                            @change="updateProp(fieldKey, $event.target.value)"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        <template x-for="option in field.options" :key="option.value">
                                            <option :value="option.value" x-text="option.label"></option>
                                        </template>
                                    </select>
                                </template>

                                <!-- Number input -->
                                <template x-if="field.type === 'number'">
                                    <input type="number"
                                           :value="selectedSection?.props?.[fieldKey]"
                                           @input="updateProp(fieldKey, parseInt($event.target.value))"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                </template>

                                <!-- Color picker -->
                                <template x-if="field.type === 'color'">
                                    <input type="color"
                                           :value="selectedSection?.props?.[fieldKey] || '#000000'"
                                           @input="updateProp(fieldKey, $event.target.value)"
                                           class="w-full h-10 px-1 py-1 border border-gray-300 rounded-lg">
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('js/admin/template-editor.js') }}"></script>
@endsection
