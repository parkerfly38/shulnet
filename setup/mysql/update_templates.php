<?php
/**
 * Template Update Script
 * Updates ppSD_templates table based on files in /pp-templates/html
 * 
 * This script iterates through theme directories and HTML files to update
 * the ppSD_templates table where:
 * - theme = subdirectory name (e.g., "zoid", "bootstrap4")
 * - id = filename minus .html extension
 */

// Include the database configuration

/**
 * Recursively scan a directory for PHP/HTML files
 * @param string $dir Directory path
 * @param string $theme Theme name
 * @return array Array of files with their info
 */
function scanTemplateFiles($dir, $theme) {
    $files = [];
    $allowedExtensions = ['php', 'html'];
    
    if (!is_dir($dir)) {
        return $files;
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, $allowedExtensions)) {
                $relativePath = str_replace($dir . '/', '', $file->getPathname());
                $templateId = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                
                $files[] = [
                    'theme' => $theme,
                    'id' => $templateId,
                    'filename' => $file->getFilename(),
                    'path' => $relativePath,
                    'full_path' => $file->getPathname(),
                    'content' => file_get_contents($file->getPathname())
                ];
            }
        }
    }
    
    return $files;
}

/**
 * Update or insert template record
 * @param object $db Database connection
 * @param array $template Template info
 */
function updateTemplate($db, $template) {
    $theme = $template['theme'];
    $id = $template['id'];
    $path = $template['path'];
    $content = $template['content'];
    
    // Check if record exists
    $checkQuery = "SELECT COUNT(*) FROM `ppSD_templates` WHERE `theme` = '".$db->mysql_clean($theme)."' AND `id` = '".$db->mysql_clean($id)."'";
    $result = $db->run_query($checkQuery);
    $row = $result->fetchColumn();
    
    if ($row > 0) {
        // Update existing record
        $updateQuery = "UPDATE `ppSD_templates` 
                       SET `content` = '".$db->mysql_clean($content)."'
                       WHERE `theme` = '".$db->mysql_clean($theme)."' AND `id` = '".$db->mysql_clean($id)."'";
        $db->update($updateQuery);
        return 'updated';
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO `ppSD_templates` 
                       (`theme`, `id`, `content`, `title`) 
                       VALUES ('".$db->mysql_clean($theme)."', '".$db->mysql_clean($id)."', '".$db->mysql_clean($content)."', '".$db->mysql_clean($path)."')";
        $db->insert($insertQuery);
        return 'inserted';
    }
}

// Main execution
try {
    echo "<h1>Template Update Script</h1>\n";
    echo "<p>Starting template scan and database update...</p>\n";
    
    $templateBaseDir = '../pp-templates/html';
    $themes = [];
    $stats = [
        'inserted' => 0,
        'updated' => 0,
        'errors' => 0
    ];
    
    // Get all theme directories
    if (is_dir($templateBaseDir)) {
        $themeDirectories = glob($templateBaseDir . '/*', GLOB_ONLYDIR);
        
        foreach ($themeDirectories as $themeDir) {
            $themeName = basename($themeDir);
            echo "<h2>Processing theme: {$themeName}</h2>\n";
            
            // Scan for template files in this theme
            $templateFiles = scanTemplateFiles($themeDir, $themeName);
            
            echo "<p>Found " . count($templateFiles) . " template files.</p>\n";
            echo "<ul>\n";
            
            foreach ($templateFiles as $template) {
                try {
                    $action = updateTemplate($db, $template);
                    $stats[$action]++;
                    
                    echo "<li><strong>{$template['id']}</strong> ({$template['filename']}) - {$action}</li>\n";
                    
                } catch (Exception $e) {
                    $stats['errors']++;
                    echo "<li><span style='color: red;'><strong>{$template['id']}</strong> - ERROR: " . $e->getMessage() . "</span></li>\n";
                }
            }
            
            echo "</ul>\n";
        }
    } else {
        echo "<p style='color: red;'>Error: Template directory not found: {$templateBaseDir}</p>\n";
    }
    
    // Display summary
    echo "<h2>Summary</h2>\n";
    echo "<ul>\n";
    echo "<li>Records inserted: {$stats['inserted']}</li>\n";
    echo "<li>Records updated: {$stats['updated']}</li>\n";
    echo "<li>Errors: {$stats['errors']}</li>\n";
    echo "</ul>\n";
    
    if ($stats['errors'] === 0) {
        echo "<p style='color: green; font-weight: bold;'>✓ Template update completed successfully!</p>\n";
    } else {
        echo "<p style='color: orange; font-weight: bold;'>⚠ Template update completed with {$stats['errors']} errors.</p>\n";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Fatal Error:</strong> " . $e->getMessage() . "</p>\n";
    echo "<p>Please check your database connection and try again.</p>\n";
}
?>