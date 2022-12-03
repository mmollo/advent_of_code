# frozen_string_literal: true

input = File.read('input').split("\n")

def priority(c)
  c.ord >= 'a'.ord ? c.ord - 96 : c.ord - 38
end

def a(input)
  input.map do |l|
    len = l.size / 2
    priority((l[..len - 1].chars & l[len..].chars).first)
  end.sum
end

def b(input)
  input.each_slice(3).map do |l|
    priority((l[0].chars & l[1].chars & l[2].chars).first)
  end.sum
end

p a(input), b(input)
