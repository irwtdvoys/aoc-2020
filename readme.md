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
