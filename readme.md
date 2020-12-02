# Advent of Code 2020

https://adventofcode.com/2020

## Notes

##### Day 01

Decided against simple in_array checks in case the data included a single 1010 value which would trigger incorrectly. Nested loops worked out very efficiently with a third layer could be added for part two.

##### Day 02

Over engineered part 1 so part two just needed a tweaked validation method. The build in php `substr_count` function did most of the heavy lifting.