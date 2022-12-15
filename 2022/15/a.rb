# frozen_string_literal: true

require 'set'

input = File.read('input').split("\n").map do |l|
  l.match(/x=([0-9-]+), y=([0-9-]+).+x=([0-9-]+), y=([0-9-]+)/).captures.map(&:to_i)
end

def man(ax, ay, bx, by)
  (ax - bx).abs + (ay - by).abs
end

def a(input, y = 2_000_000)
  allowed_places = []
  beacons = []

  input.each do |sx, sy, bx, by|
    dist = man(sx, sy, bx, by) - (sy - y).abs

    next if dist.negative?

    covered_places = (sx - dist)..(sx + dist)
    allowed_places += covered_places.to_a
    beacons << [bx, by] if by == y
  end

  allowed_places.uniq.size - beacons.uniq.size
end

def b(input); end

p a(input)
p b(input)
