#!/usr/bin/env php
<?php
/**
 * Database Call Analysis Script
 * 
 * This script scans the codebase for database calls that need to be converted
 * to the new parameter binding approach.
 */

if (!isset($argv[1])) {
    echo "Usage: php db_conversion_scanner.php <directory>\n";
    echo "Example: php db_conversion_scanner.php admin/\n";
    exit(1);
}

$directory = $argv[1];
if (!is_dir($directory)) {
    echo "Error: Directory '$directory' not found.\n";
    exit(1);
}

// Patterns to look for
$patterns = [
    'insert_concat' => '/\$db->insert\([^)]*\.[^)]*\)/',
    'update_concat' => '/\$db->update\([^)]*\.[^)]*\)/',
    'delete_concat' => '/\$db->delete\([^)]*\.[^)]*\)/',
    'select_concat' => '/\$db->get_array\([^)]*\.[^)]*\)/',
    'runquery_concat' => '/\$db->run_query\([^)]*\.[^)]*\)/',
    'mysql_clean' => '/\$db->mysql_clean\(/',
    'direct_concat' => '/VALUES\s*\([^)]*\$[^)]*\)/',
    'where_concat' => '/WHERE\s+[^=]*=\s*[\'"][^\'"]*\$[^\'"]*[\'"]/',
];

// Risk levels
$risk_levels = [
    'insert_concat' => 'HIGH',
    'update_concat' => 'HIGH', 
    'delete_concat' => 'HIGH',
    'select_concat' => 'MEDIUM',
    'runquery_concat' => 'MEDIUM',
    'mysql_clean' => 'LOW',
    'direct_concat' => 'HIGH',
    'where_concat' => 'HIGH',
];

function scanDirectory($dir) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    
    return $files;
}

function analyzeFile($filepath, $patterns, $risk_levels) {
    $content = file_get_contents($filepath);
    $lines = explode("\n", $content);
    $issues = [];
    
    foreach ($patterns as $pattern_name => $pattern) {
        if (preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
            foreach ($matches[0] as $match) {
                $line_number = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                $line_content = trim($lines[$line_number - 1]);
                
                $issues[] = [
                    'type' => $pattern_name,
                    'risk' => $risk_levels[$pattern_name],
                    'line' => $line_number,
                    'content' => $line_content,
                    'match' => $match[0]
                ];
            }
        }
    }
    
    return $issues;
}

// Scan directory
echo "Scanning directory: $directory\n";
echo "Looking for database calls that need conversion...\n\n";

$files = scanDirectory($directory);
$total_issues = 0;
$high_risk_files = [];
$medium_risk_files = [];
$low_risk_files = [];

foreach ($files as $file) {
    $issues = analyzeFile($file, $patterns, $risk_levels);
    
    if (!empty($issues)) {
        $has_high = false;
        $has_medium = false;
        
        foreach ($issues as $issue) {
            if ($issue['risk'] === 'HIGH') $has_high = true;
            if ($issue['risk'] === 'MEDIUM') $has_medium = true;
        }
        
        if ($has_high) {
            $high_risk_files[] = ['file' => $file, 'issues' => $issues];
        } elseif ($has_medium) {
            $medium_risk_files[] = ['file' => $file, 'issues' => $issues];
        } else {
            $low_risk_files[] = ['file' => $file, 'issues' => $issues];
        }
        
        $total_issues += count($issues);
    }
}

// Report results
echo "=== DATABASE CONVERSION ANALYSIS ===\n\n";

echo "HIGH RISK FILES (SQL Injection Vulnerable):\n";
echo str_repeat("-", 50) . "\n";
foreach ($high_risk_files as $file_data) {
    $relative_path = str_replace(getcwd() . '/', '', $file_data['file']);
    echo "📁 $relative_path\n";
    
    foreach ($file_data['issues'] as $issue) {
        if ($issue['risk'] === 'HIGH') {
            echo "  ⚠️  Line {$issue['line']}: {$issue['type']}\n";
            echo "      " . substr($issue['content'], 0, 80) . "...\n";
        }
    }
    echo "\n";
}

echo "\nMEDIUM RISK FILES:\n";
echo str_repeat("-", 50) . "\n";
foreach ($medium_risk_files as $file_data) {
    $relative_path = str_replace(getcwd() . '/', '', $file_data['file']);
    echo "📁 $relative_path (" . count($file_data['issues']) . " issues)\n";
}

echo "\nLOW RISK FILES:\n";
echo str_repeat("-", 50) . "\n";
foreach ($low_risk_files as $file_data) {
    $relative_path = str_replace(getcwd() . '/', '', $file_data['file']);
    echo "📁 $relative_path (" . count($file_data['issues']) . " issues)\n";
}

echo "\n=== SUMMARY ===\n";
echo "Total files scanned: " . count($files) . "\n";
echo "Total issues found: $total_issues\n";
echo "High risk files: " . count($high_risk_files) . "\n";
echo "Medium risk files: " . count($medium_risk_files) . "\n";
echo "Low risk files: " . count($low_risk_files) . "\n\n";

echo "RECOMMENDATION:\n";
echo "1. Start with HIGH RISK files immediately\n";
echo "2. Convert MEDIUM RISK files next\n";
echo "3. Update LOW RISK files during regular maintenance\n\n";

echo "See db_conversion_guide.md for conversion patterns\n";
?>