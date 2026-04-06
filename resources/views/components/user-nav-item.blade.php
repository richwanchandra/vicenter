{{--
Recursive nav item component.
@param $module - Module model with loaded children relation
@param $isRoot - boolean, true if this is a top-level navbar item
--}}

@php
    $hasChildren = $module->children && $module->children->count() > 0;
    $currentPageModule = request()->route('module'); // This is the Module model from the route
    $currentPageSlug = $currentPageModule ? $currentPageModule->slug : null;
    $isActive = ($currentPageSlug === $module->slug);

    // Check if target module is a descendant of the current page's module
    $isDescendantOfCurrentPage = false;
    if ($currentPageModule && !$isActive) {
        $checkIfDescendant = function($parent, $targetSlug) use (&$checkIfDescendant) {
            foreach($parent->children as $child) {
                if ($child->slug === $targetSlug) return true;
                if ($checkIfDescendant($child, $targetSlug)) return true;
            }
            return false;
        };
        $isDescendantOfCurrentPage = $checkIfDescendant($currentPageModule, $module->slug);
    }

    // Determine the URL
    // If it's on the current page, use anchor. Otherwise, use full route.
    $moduleUrl = $isDescendantOfCurrentPage 
        ? '#' . 'module-' . $module->slug 
        : route('module.show', $module->slug);

    // Check if any descendant is active (for parent highlight)
    $isAncestorActive = false;
    if ($hasChildren) {
        $checkDescendants = function ($mod) use (&$checkDescendants, $currentPageSlug) {
            foreach ($mod->children as $child) {
                if ($child->slug === $currentPageSlug)
                    return true;
                if ($child->children && $child->children->count() > 0) {
                    if ($checkDescendants($child))
                        return true;
                }
            }
            return false;
        };
        $isAncestorActive = $checkDescendants($module);
    }
@endphp

@if($isRoot)
    {{-- Root level: top navbar item (mega dropdown) --}}
    <div class="vims-nav-root {{ ($isActive || $isAncestorActive) ? 'active' : '' }} {{ $hasChildren ? 'has-children' : '' }}">
        @if($hasChildren)
            @php
                $clickableCategories = [''];
            @endphp
            @if(in_array($module->name, $clickableCategories))
                <a href="{{ $moduleUrl }}" class="vims-nav-link">
                    {{ $module->name }}
                    <i class="fas fa-chevron-down caret"></i>
                </a>
            @else
                <div class="vims-nav-link" style="cursor: default;">
                    {{ $module->name }}
                    <i class="fas fa-chevron-down caret"></i>
                </div>
            @endif
            <div class="vims-dropdown vims-mega">
                <div class="vims-mega-inner">
                    <div class="vims-mega-left">
                        @foreach($module->children as $idx => $child)
                            @php
                                $isChildDescendant = false;
                                if ($currentPageModule) {
                                    $checkIfDescendant = function($parent, $targetSlug) use (&$checkIfDescendant) {
                                        foreach($parent->children as $c) {
                                            if ($c->slug === $targetSlug) return true;
                                            if ($checkIfDescendant($c, $targetSlug)) return true;
                                        }
                                        return false;
                                    };
                                    $isChildDescendant = ($currentPageModule->slug === $child->slug) || $checkIfDescendant($currentPageModule, $child->slug);
                                }
                                $childUrl = $isChildDescendant ? '#module-' . $child->slug : route('module.show', $child->slug);
                            @endphp
                            @if($child->children && $child->children->count() > 0)
                                <div class="vims-mega-left-item {{ $idx === 0 ? 'active' : '' }}"
                                     data-target="mega-{{ $module->slug }}-{{ $child->id }}" style="cursor: default;">
                                    <span>{{ $child->name }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            @else
                                <a href="{{ $childUrl }}"
                                   class="vims-mega-left-item {{ $idx === 0 ? 'active' : '' }}"
                                   data-target="mega-{{ $module->slug }}-{{ $child->id }}">
                                    <span>{{ $child->name }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div class="vims-mega-right">
                        @foreach($module->children as $idx => $child)
                            <div class="vims-mega-panel {{ $idx === 0 ? 'active' : '' }}"
                                 id="mega-{{ $module->slug }}-{{ $child->id }}">
                                <div class="vims-mega-panel-header vims-mobile-toggle-grid" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                    <h4>Explore {{ $child->name }}</h4>
                                    <span class="vims-mobile-only grid-caret">
                                        <i class="fas fa-chevron-down"></i>
                                        <i class="fas fa-chevron-up"></i>
                                    </span>
                                </div>
                                @if($child->children && $child->children->count() > 0)
                                    <div class="vims-mega-grid">
                                        @foreach($child->children as $gchild)
                                            @php
                                                $isGChildDescendant = false;
                                                if ($currentPageModule) {
                                                    $isGChildDescendant = ($currentPageModule->slug === $gchild->slug) || $checkIfDescendant($currentPageModule, $gchild->slug);
                                                }
                                                $gchildUrl = $isGChildDescendant ? '#module-' . $gchild->slug : route('module.show', $gchild->slug);
                                            @endphp
                                            <a class="vims-mega-link"
                                               href="{{ $gchildUrl }}">{{ $gchild->name }}</a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="vims-mega-empty" style="color:var(--vims-text-light);font-size:0.9rem;">
                                        No sub-modules
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <a href="{{ $moduleUrl }}" class="vims-nav-link">
                {{ $module->name }}
            </a>
        @endif
    </div>
@else
    {{-- Nested level: sidebar/dropdown item --}}
    <div class="vims-dropdown-item {{ $hasChildren ? 'has-submenu' : '' }} {{ ($isActive || $isAncestorActive) ? 'expanded' : '' }}">
        <a href="{{ $moduleUrl }}" class="vims-dropdown-link {{ $isActive ? 'active-link' : '' }}">
            <span>{{ $module->name }}</span>
            @if($hasChildren)
                <span class="sub-caret">
                    <i class="fas fa-chevron-down"></i>
                    <i class="fas fa-chevron-up"></i>
                </span>
            @endif
        </a>

        @if($hasChildren)
            <div class="vims-submenu {{ ($isActive || $isAncestorActive) ? 'open' : '' }}">
                @foreach($module->children as $child)
                    @include('components.user-nav-item', ['module' => $child, 'isRoot' => false])
                @endforeach
            </div>
        @endif
    </div>
@endif
