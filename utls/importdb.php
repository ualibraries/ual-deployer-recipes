<?php
/**
 * Script for importing a database dump file
 * Designed to be run from the Deployer config file (config.php)
 * Example: php src/util/importdb.php --filename=dump.sql.gz
 */

//$project_root = __DIR__ . '/../..';
$project_root = '/home/cao89/Development/ltt';
require $project_root . '/vendor/autoload.php';

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Yaml\Yaml;

$yamlparse = Yaml::parseFile($project_root . '/app/config/parameters.yml');
$parameters = $yamlparse['parameters'];

$db_user = $parameters['database_user'];
$db_pass = $parameters['database_password'];
$db_database = $parameters['database_name'];

// Get database export filename
$input = new ArgvInput();
$db_filename = $input->getParameterOption('--filename');
$db_sql_filename = basename($db_filename, '.gz');

// Unzip the export file
$command = "gzip --decompress --force {$project_root}/tmp/{$db_filename}";
// Import
$command .= " && mysql -u {$db_user} -p{$db_pass} {$db_database} < {$project_root}/tmp/{$db_sql_filename}";
// Remove the export file
$command .= " && rm {$project_root}/tmp/{$db_sql_filename}";

$process = new Process($command);
$process->run();

// Executes after the command finishes
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

echo $process->getOutput();
