# frozen_string_literal: true

# Don't do that, it's evil
class Array
  require 'json'
  def deep_clone
    JSON.parse(dup.to_json)
  end
end

def compare(p1, p2)
  return compare(p1, [p2]) if p1.is_a?(Array) && p2.is_a?(Integer)

  return compare([p1], p2) if p1.is_a?(Integer) && p2.is_a?(Array)

  if p1.is_a?(Array) && p2.is_a?(Array)
    while p1.count.positive? && p2.count.positive?
      res = compare(p1.shift, p2.shift)
      next if res.zero?

      return res
    end

    return 0 if p1.empty? && p2.empty?
    return -1 if p1.empty?
    return 1 if p2.empty?

  end

  return 0 if p1 == p2
  return -1 if p1 < p2
  return 1 if p1 > p2
end

def a(input)
  t = []
  input.each_with_index do |pairs, i|
    t << i + 1 if compare(*pairs) == -1
  end

  t.sum
end

def b(input)
  res = (input.reduce(&:+) + [[[2]], [[6]]]).sort do |a, b|
    compare(a.deep_clone, b.deep_clone)
  end

  [2, 6].map { |i| 1 + res.find_index([[i]]) }.inject(:*)
end

# Don't use eval :(
input = File.read('input').split("\n\n").map do |pairs|
  pairs.split("\n").map { |pair| eval(pair) }
end

p a(input.deep_clone), b(input.deep_clone)
