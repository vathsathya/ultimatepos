<?php

namespace App\Http;

class AdminlteCustomPresenter
{
    protected $menu;

    public function __construct($menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        $html = $this->getOpenTagWrapper();

        foreach ($this->menu->getItems() as $item) {
            if (count($item->getChilds()) > 0) {
                $html .= $this->getMenuWithDropDownWrapper($item);
            } else {
                $html .= $this->getMenuWithoutDropdownWrapper($item);
            }
        }

        $html .= $this->getCloseTagWrapper();

        return $html;
    }

    /**
     * {@inheritdoc}.
     */
    public function getOpenTagWrapper()
    {
        return '<div class="tw-flex-1 tw-p-3 tw-space-y-3 tw-overflow-y-auto tw-border-r tw-border-gray-200" id="side-bar">' . PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getCloseTagWrapper()
    {
        return '</div>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<a href="' . $item->getUrl() . '" title="" class="tw-flex tw-items-center tw-gap-3 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-tracking-tight tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg tw-whitespace-nowrap hover:tw-text-gray-900 hover:tw-bg-gray-100' . $this->getActiveState($item) . '" ' . $item->getAttributes() . '>' .
            $this->formatIcon($item->icon) . ' <span class="tw-truncate">' . $item->title . '</span>' .
            '</a>' . PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getActiveState($item, $state = ' tw-bg-gray-200 tw-text-primary-700')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param  string  $state
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'tw-pb-1 tw-rounded-md tw-bg-gray-200 tw-text-primary-700')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc}.
     */
    public function getDividerWrapper()
    {
        // Assuming a divider is just a visual space in this design
        return '<div class="tw-my-2"></div>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getHeaderWrapper($item)
    {
        return '<div class="tw-px-3 tw-py-2 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wider">' . $item->title . '</div>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        $activeClass = $this->getActiveStateOnChild($item, ' tw-bg-gray-200 tw-text-primary-700');
        $dropdownToggle = '<a href="#" title="" class="drop_down tw-flex tw-items-center tw-gap-3 tw-px-3 tw-py-2 tw-text-sm tw-font-medium tw-tracking-tight tw-text-gray-600 tw-transition-all tw-duration-200 tw-rounded-lg tw-whitespace-nowrap hover:tw-text-gray-900 hover:tw-bg-gray-100 focus:tw-text-gray-900 focus:tw-bg-gray-100' . $activeClass . '" ' . $item->getAttributes() . '>' .
            $this->formatIcon($item->icon) . ' <span class="tw-truncate">' . $item->title . '</span>' .
            '<svg aria-hidden="true" class="svg tw-ml-auto tw-text-gray-500 tw-size-4 tw-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">' . $this->getArray($item) .
            '</svg>' .
            '</a>';

        $childItemsContainerStart = '';

        $childItemsContainerEnd = '';

        // Compile child menu items
        $childItems = $this->getChildMenuItems($item);

        return '<div class="tw-mb-1">' . $dropdownToggle . $childItemsContainerStart . $childItems . $childItemsContainerEnd . '</div>' . PHP_EOL;
    }

    /**
     * Get child menu items.
     *
     * @param  mixed  $item
     * @return string
     */
    public function getChildMenuItems($item)
    {
        $children = '';
        $displayStyle = $item->hasActiveOnChild() ? 'block' : 'none';

        if (count($item->getChilds()) > 0) {
            $children .= '<div class=" chiled tw-relative tw-mt-2 tw-mb-4 tw-pl-11" style="display:' . $displayStyle . '">
            <div class="tw-absolute tw-inset-y-0 tw-w-px tw-h-full tw-bg-gray-200 tw-left-5"></div>
            <div class="tw-space-y-3.5">';

            foreach ($item->getChilds() as $child) {
                $isActive = $child->isActive() ? ' tw-text-primary-700' : '';

                $children .= '<a href="' . $child->getUrl() . '" title="" class="tw-flex tw-text-sm tw-font-medium tw-tracking-tight tw-text-gray-600 tw-truncate tw-transition-all tw-duration-200 hover:tw-text-gray-900 tw-whitespace-nowrap' . $isActive . '" ' . $child->getAttributes() . '>' .
                    $this->formatIcon($child->icon) . ' <span>' . $child->title . '</span>' .
                    '</a>' . PHP_EOL;
            }

            $children .= '</div></div>';
        }

        return $children;
    }

    /**
     * Returns the icon HTML.
     *
     * @param string $icon
     * @return string
     */
    protected function formatIcon($icon)
    {
        if (strpos($icon, '<svg') !== false) {
            return $icon;
        } else {
            return '<i class="' . $icon . '"></i>';
        }
    }

    public function getArray($item)
    {
        if ($item->hasActiveOnChild()) {
            return '<path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M6 9l6 6l6 -6" />';
        } else {
            return '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M15 6l-6 6l6 6" />';
        }
    }
}
