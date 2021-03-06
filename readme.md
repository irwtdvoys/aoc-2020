# Advent of Code 2020

https://adventofcode.com/2020

## Notes

##### Day 01

Decided against simple in_array checks in case the data included a single 1010 value which would trigger incorrectly. Nested loops worked out very efficiently with a third layer could be added for part two.

##### Day 02

Over engineered part 1 so part two just needed a tweaked validation method. The build in php `substr_count` function did most of the heavy lifting.

##### Day 03

Was expecting more from part 2, in the end the way I had writen part 1 made it trivial by using `array_product`.

##### Day 04

No issues today. Validation rules were a nice test of my simple regex knowledge.

##### Day 05

Easier than expected for the first weekend puzzle. Understood the binary nature of the input strings so there wasn't a lot to do for part one. Part two I chose to do by calculation rather than searching through the result list.

##### Day 06

Didn't have a lot of time so there's probably a more efficient way of merging the group data but not much to it today.

##### Day 07

Solved with some recursion and built the data structure from references keeping the data structure minimal while allowing full traversal.

##### Day 08

Might have overengineered the VM as I'm hoping it'll be used again like the intcode VM from 2020.

##### Day 09

Fairly basic day, nothing crazy just implemented the algorithm with a few loops.

##### Day 10

Spent far too long trying to optimise the recursion for part 2 instead of fining a simpler solution.

##### Day 11

Didn't write a good solution for part 1 so the checking system for part 2 didn't use much reused code.

##### Day 12

Remembered a nice simple ray to rotate around the origin in 90 degree steps without having to fall back on trigonometry which was nice!

##### Day 13

The number theory wasn't something I've ever come across before so was a bit out of my depth. Was able to convert some Rosettacode examples to PHP to complete part 2.

##### Day 14

Found a way to generate all masks for part 2 with iteration instead of recursion which worked out pretty well.

##### Day 15

Had a pretty optimal solution for part 1 and was hopeful for part 2, was still hitting oom errors so gave it a rethink to avoid saving the last two occurances of each number.

##### Day 17

A bit hacky, was running short on time. Nice unexpected addition for part 2 but was simple enough to add another dimension to my data structure.

##### Day 18

Nice and easy today, optimised with recursion for the parentheses, the rest was handles by loops. Made use of basic array and string manipulations in different areas.

##### Day 19

Fun with regex, used recursion to generate the main regex but for part 2 had to find ways to break out of it correctly. Also had to optimise the regex a bit in part 2 as I was hitting the upper limit that PHP could handle.

##### Day 22

Fun task, the classes created for part one were easy to use and extend for the recursive version in part 2.

##### Day 23

Used a circular linked list for part 1 so only needed to add an index to make it so part 2 would finish before the heat death of the universe.

##### Day 24

I've always wanted to play with hex grids so had done a lot of research on appropriate data structures in the past. Was able to use 3D positions with additional valid location checks, after that pretty straight forward.

##### Day 25

Nice simple one for Christmas day =)
