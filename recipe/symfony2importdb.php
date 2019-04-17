<?php

namespace Deployer;

// Import remote database
// Import remote database
task('import-remote-db', function () {
    cd('{{release_path}}');
    run('pwd');
    // // Export the remote database and get the name of the export file
    // $db_path = run('php src/util/exportdb.php');
    // $db_filename = basename($db_path);
    // $db_sql_filename = basename($db_filename, '.sql');

    // // Download the remote database export
    // download($db_path, __DIR__ . '/../../tmp');
    // // Remove the database export on the remote host
    // run("rm {$db_path}");
    // // Import the database export
    // runLocally("php ../utls/importdb.php --filename={$db_filename}");
});
