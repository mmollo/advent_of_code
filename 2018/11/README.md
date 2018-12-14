# Day 11

## Part A

Quite easy with brute force...

## Part B

... and of course, brute force was not the answer.
I tried to store the power of each cell, it was still to slow. Even slower than
without no caching!
I tried to cache the power for whole selected zone and calculate recursively.
It worked, until my ram exploded :(

It seems the best solution is with summer-area tables, which of I'm totaly
ignorant, but I found a good explanation:
https://blog.demofox.org/2018/04/16/prefix-sums-and-summed-area-tables/

Once again, there's the proof that I suck at math.
