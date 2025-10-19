<?php
/**
 * Email Template Content Migration Script
 * Moves content from files in /pp-templates/email into ppSD_templates_email table
 * 
 * This script reads email template files and stores their content in the database where:
 * - theme = subdirectory name (e.g., "threefiveten")
 * - id = filename minus .html extension
 * - content = full file content moved to database
 */

// Include the database configuration

/**
 * Scan email template files in a theme directory
 * @param string $dir Directory path
 * @param string $theme Theme name
 * @return array Array of files with their info
 */
function scanEmailTemplateFiles($dir, $theme) {
    $files = [];
    
    if (!is_dir($dir)) {
        return $files;
    }
    
    $handle = opendir($dir);
    while (($file = readdir($handle)) !== false) {
        if ($file != '.' && $file != '..' && !is_dir($dir . '/' . $file)) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if ($extension === 'html') {
                $templateId = pathinfo($file, PATHINFO_FILENAME);
                
                // Skip CSS and other non-template files
                if (in_array($templateId, ['email_styles', 'styles', 'style'])) {
                    continue;
                }
                
                $files[] = [
                    'theme' => $theme,
                    'id' => $templateId,
                    'filename' => $file,
                    'full_path' => $dir . '/' . $file
                ];
            }
        }
    }
    closedir($handle);
    
    return $files;
}

/**
 * Read template content from file
 * @param string $filePath Full path to template file
 * @return string Template content
 */
function getTemplateContent($filePath) {
    if (file_exists($filePath) && is_readable($filePath)) {
        return file_get_contents($filePath);
    }
    return '';
}

/**
 * Update or insert email template content into database
 * @param object $db Database connection
 * @param array $template Template info
 */
function updateEmailTemplateContent($db, $template) {
    $theme = $template['theme'];
    $id = $template['id'];
    
    // Get template content from file
    $content = getTemplateContent($template['full_path']);
    if (empty($content)) {
        throw new Exception("Could not read file content");
    }
    
    // Check if record exists
    $checkQuery = "SELECT COUNT(*) as count FROM `ppSD_templates_email` WHERE `theme` = '".$db->mysql_clean($theme)."' AND `template` = '".$db->mysql_clean($id)."'";
    $result = $db->run_query($checkQuery);
    $row = $result->fetchColumn();
    
    if ($row > 0) {
        // Update existing record with content
        $updateQuery = "UPDATE `ppSD_templates_email` 
                       SET `content` = '".$db->mysql_clean($content)."'
                       WHERE `theme` = '".$db->mysql_clean($theme)."' AND `template` = '".$db->mysql_clean($id)."'";
        $db->update($updateQuery);
        return 'content_updated';
    } else {
        // Insert new record with content
        $insertQuery = "INSERT INTO `ppSD_templates_email` 
                       (`theme`, `template`, `content`, `created`) 
                       VALUES ('".$db->mysql_clean($theme)."', '".$db->mysql_clean($id)."', '".$db->mysql_clean($content)."', NOW())";
        $db->insert($insertQuery);
        return 'content_inserted';
    }
}


// Main execution
try {
    echo "<h1>Email Template Content Migration Script</h1>\n";
    echo "<p>Moving email template content from files to database...</p>\n";
    
    // Create table if it doesn't exist
    
    $templateBaseDir = '../pp-templates/email';
    $stats = [
        'content_inserted' => 0,
        'content_updated' => 0,
        'errors' => 0
    ];
    
    // Get all theme directories
    if (is_dir($templateBaseDir)) {
        $themeDirectories = glob($templateBaseDir . '/*', GLOB_ONLYDIR);
        
        if (empty($themeDirectories)) {
            echo "<p style='color: orange;'>No theme directories found in {$templateBaseDir}</p>\n";
        }
        
        foreach ($themeDirectories as $themeDir) {
            $themeName = basename($themeDir);
            echo "<h2>Processing email theme: {$themeName}</h2>\n";
            
            // Scan for email template files in this theme
            $templateFiles = scanEmailTemplateFiles($themeDir, $themeName);
            
            echo "<p>Found " . count($templateFiles) . " email template files.</p>\n";
            
            if (!empty($templateFiles)) {
                echo "<ul>\n";
                
                foreach ($templateFiles as $template) {
                    try {
                        $action = updateEmailTemplateContent($db, $template);
                        $stats[$action]++;
                        
                        $fileSize = filesize($template['full_path']);
                        $sizeKb = round($fileSize / 1024, 2);
                        echo "<li><strong>{$template['id']}</strong> ({$template['filename']}) - {$action} [{$sizeKb} KB moved to database]</li>\n";
                        
                    } catch (Exception $e) {
                        $stats['errors']++;
                        echo "<li><span style='color: red;'><strong>{$template['id']}</strong> - ERROR: " . htmlspecialchars($e->getMessage()) . "</span></li>\n";
                    }
                }
                
                echo "</ul>\n";
            } else {
                echo "<p style='color: orange;'>No email template files found in this theme.</p>\n";
            }
        }
    } else {
        echo "<p style='color: red;'>Error: Email template directory not found: {$templateBaseDir}</p>\n";
    }
    
    // Display summary
    echo "<h2>Migration Summary</h2>\n";
    echo "<ul>\n";
    echo "<li>Content inserted (new records): {$stats['content_inserted']}</li>\n";
    echo "<li>Content updated (existing records): {$stats['content_updated']}</li>\n";
    echo "<li>Errors: {$stats['errors']}</li>\n";
    echo "</ul>\n";
    
    $totalProcessed = $stats['content_inserted'] + $stats['content_updated'];
    
    if ($stats['errors'] === 0 && $totalProcessed > 0) {
        echo "<p style='color: green; font-weight: bold;'>✓ Email template content migration completed successfully!</p>\n";
        echo "<p><strong>All email template content has been moved from files to the database.</strong></p>\n";
    } elseif ($stats['errors'] > 0) {
        echo "<p style='color: orange; font-weight: bold;'>⚠ Email template migration completed with {$stats['errors']} errors.</p>\n";
    } else {
        echo "<p style='color: blue;'>ℹ No templates found to migrate.</p>\n";
    }
    
    // Next steps information
    echo "<h3>Next Steps</h3>\n";
    echo "<ul>\n";
    echo "<li>Email template content is now stored in the <code>ppSD_templates_email</code> table</li>\n";
    echo "<li>Each template is identified by <code>theme</code> + <code>id</code> (filename without .html)</li>\n";
    echo "<li>The original files can be kept as backups or removed if desired</li>\n";
    echo "<li>Your application should now read email templates from the database instead of files</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Fatal Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<p>Please check your database connection and try again.</p>\n";
}
?>