# Day 9

## Part A

Horrible. I'm ashamed. I used arrays in PHP to get a good result. The code was
a mess and very slow.


## Part B

I thought the A solution would be good enough, but an array of 7M entries is
just too much. So I tried to implement the same algorithm in Go, but it was
still too slow.

I looked for help on r/adventofcode and realized how wrong I was after seeing
so many nice solutions using doubly linked lists.

https://old.reddit.com/r/adventofcode/comments/a4i97s/2018_day_9_solutions/ebepyc7/
collections/deque in Python looks awesome.

I've tried to use SplDoublyLinkedList but fail to see how it would help without
insert_at or remove_at methods.

https://old.reddit.com/r/adventofcode/comments/a4i97s/2018_day_9_solutions/ebepjmd/
This is what I need, so implemented it in PHP.
PHP is killed by OOM with 7M nodes.
So I tried the same thing in C, for fun, inspired from 
https://gist.github.com/mycodeschool/7429492

I think I got it almost right. It works. It's blazing fast.

