<?php

require 'vendor/autoload.php';

use mikehaertl\shellcommand\Command;

$dir = $argv[1];

$merges = $argv[2] ? " --merges " : " ";

$command = new Command("git --git-dir $dir/.git log$merges--pretty=\"%cd\" | cut -d' ' -f4 | cut -d: -f1 | sort -n | uniq -c");

if ($command->execute()) {
    $out = $command->getOutput();
} else {
    echo $command->getError();
    $exitCode = $command->getExitCode();
    die;
}

$tmp = explode("\n", preg_replace(['/[ ]{5,6}/', '/([0-9])+ /'], ['', '$1,'], $out));
$data = [];

foreach ($tmp as $element) {
	list($commits, $hour) = explode(',', $element);
	$data[(string)$hour] = (int)$commits;
}

unset($tmp);
$max = max($data);
$count = count($data);

echo "\n";

for($row = 10; $row > 0; $row--)
{
	echo "| ";
	foreach ($data as $hour => $commits)
	{
		$normilize = (int)(round($commits / $max, 1) * 10);
		echo $normilize >= $row ? ' # ' : '   ';
	}

	echo "\n";
}

for($row = 0; $row < 2; $row++)
{
	if($row == 0)
	{
		for($c = 0; $c < ($count*3) + 4; $c++)
			echo "-";

		echo "\n";

	} else {

		echo "  ";
		foreach($data as $hour => $commits)
			echo "$hour ";
	}

}

echo "\n";
