<?php

namespace App\Helpers;

use App\Models\SubjectArea;

class HeaderHelper
{
    public static function getSubjectAreasForMenu()
    {
        try {
            $areas = SubjectArea::getAll();
            return is_array($areas) ? $areas : [];
        } catch (\Exception $e) {
            error_log('HeaderHelper::getSubjectAreasForMenu error: ' . $e->getMessage());
            return [];
        }
    }

    public static function renderSubjectAreasMenu()
    {
        $areas = self::getSubjectAreasForMenu();
        
        if (empty($areas)) {
            echo '<li>Subject Areas<ul><li><a href="#">No areas available</a></li></ul></li>';
            return;
        }
        
        echo '<li>Subject Areas<ul>';
        echo '<li><a href="/course-search">Search Courses</a></li>';
        echo '<li style="border-top: 1px solid #ddd; margin: 5px 0; padding-top: 5px;"></li>';
        foreach ($areas as $area) {
            $name = htmlspecialchars($area['name']);
            $id = (int)$area['id'];
            echo "<li><a href=\"/subject-area/{$id}\">{$name}</a></li>";
        }
        echo '</ul></li>';
    }
}
