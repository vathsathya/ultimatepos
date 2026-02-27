<?php

namespace Modules\Telegram\Http\Controllers;

use Illuminate\Routing\Controller;

class DataController extends Controller
{
    /**
     * Menu is now registered centrally in AdminSidebarMenu middleware.
     * This method is intentionally left empty to avoid duplicate entries.
     */
    public function modifyAdminMenu()
    {
        // No-op: Telegram is a root-level menu item added in AdminSidebarMenu.php
    }
}
