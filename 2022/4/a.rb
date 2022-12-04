# frozen_string_literal: true

input = File.read('input').split("\n").map do |l|
  a, b, c, d = l.match(/(\d+)-(\d+),(\d+)-(\d+)/).captures.map(&:to_i)
  [(a..b).to_a, (c..d).to_a]
end

def a(input)
  input.filter_map { |r1, r2| [r1, r2].include?(r1 & r2) || nil }.count
end

def b(input)
  input.filter_map { |r1, r2| (r1 & r2).any? || nil }.count
end

p a(input), b(input)
