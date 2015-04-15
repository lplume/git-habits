simple script inspired by Linus Torvalds
on g+ (https://plus.google.com/u/0/+LinusTorvalds/posts/9EuaUEgarfu).

The idea is to inspect git log to see
your activity through the day.

This script git log and stuff and print out
a normilized table (0-10) of commits.

you need composer to install a simple dependency.

composer install

php habit.php path-to-git-repos [merges]

merges is default false, if true it add --merges option
