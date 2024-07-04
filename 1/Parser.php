<?php

class Parser
{
    public static function getResults(string $filename): array
    {
        $lines = file($filename);
        $results = [];
        for ($i = 1; $i < count($lines); $i++)
        {
            $parsedLine = explode(";", $lines[$i]);
            if (self::validateLine($parsedLine)) {
                $results[] = $parsedLine;
            } else {
                self::writeBrokeLine($lines[$i]);
            }
        }

        return $results;
    }

    public static function validateLine(array $parsedLine): bool
    {
        return count($parsedLine) == 3 &&
                is_numeric($parsedLine[0]) &&
                is_numeric($parsedLine[1]) &&
                is_string($parsedLine[2]);
    }

    private static function writeBrokeLine($line): void
    {
        $f = fopen("broken.txt", "a+");
        fwrite($f, $line);
        fclose($f);
    }
}