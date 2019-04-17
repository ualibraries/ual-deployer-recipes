<?php
/**
 * Script for exporting a database
 * Connects to the local mysql instance using the credentials in .env
 * Example: php src/util/exportdb.php
 */


//$project_root = __DIR__ . '/../..';
$project_root = '/home/cao89/Development/ltt';
require $project_root . '/vendor/autoload.php';

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Yaml\Yaml;

$yamlparse = Yaml::parseFile($project_root . '/app/config/parameters.yml');
$parameters = $yamlparse['parameters'];

$db_user = $parameters['database_user'];
$db_pass = $parameters['database_password'];
$db_database = $parameters['database_name'];

// Dump the remote database
$command = "mysqldump -u {$db_user} -p{$db_pass} {$db_database} | gzip > {$project_root}/tmp/{$db_database}.sql.gz";
// Echo the path to the database dump file
$command .= " && echo {$project_root}/tmp/{$db_database}.sql.gz";

$process = new Process($command);
$process->run();

// executes after the command finishes
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

echo $process->getOutput();
