<?php

declare(strict_types=1);

function getTransactionFiles(string $dirPath): array
{
    $csvFiles = [];
    $error = [];

    foreach (scandir($dirPath) as $file) {
        if (is_dir($file)) continue;
        match (pathinfo($file)['extension']) {
            "csv" => $csvFiles[] = $dirPath . $file,
            default => $error[] = "Unsupported '" . $file . "' extension"
        };
    };

    return $csvFiles;
};

function getTransactionsCSV(string $fileName): array
{
    if (!file_exists($fileName)) {
        trigger_error("File '" . $fileName . "' does not exists!", E_USER_ERROR);
    };

    $file = fopen($fileName, 'r');

    $transactions = [];
    while (($transaction = fgetcsv($file)) !== false) {
        $transactions[] = $transaction;
    }

    return $transactions;
}