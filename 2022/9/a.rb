# frozen_string_literal: true

class Knot
  attr_accessor :x, :y, :to

  def initialize(pos_x = 0, pos_y = 0)
    @x = pos_x
    @y = pos_y
    @to = nil
  end

  def join(knot) = knot.to = self

  def move(direction)
    send(direction)
    sync
  end

  def u = @y += 1
  def d = @y -= 1
  def l = @x -= 1
  def r = @x += 1

  # This sucks
  def sync
    return if to.nil? || adj?

    if diag?
      to.x > x ? to.l : to.r
      to.y > y ? to.d : to.u
    elsif to.x == x
      to.y > y ? to.d : to.u
    elsif to.y == y
      to.x > x ? to.l : to.r
    end
    to.sync
  end

  def adj? = (x - to.x).abs < 2 && (y - to.y).abs < 2
  def diag? =  x != to.x && y != to.y
  def pos =    [x, y]
end

def build(file)
  File.read(file).split("\n").each_with_object([]) do |move, directions|
    direction, amount = move.split
    amount.to_i.times { directions << direction.downcase.to_sym }
  end
end

def rope(size)
  rope = []
  size.times do |i|
    rope[i] = Knot.new
    next if i.zero?

    rope[i].join(rope[i - 1])
  end
  rope
end

def run(input, size)
  rope = rope(size)
  input.map do |direction|
    rope.first.move(direction)
    rope.last.pos
  end.uniq.count
end

def a(input)
  run(input, 2)
end

def b(input)
  run(input, 10)
end

input = build('input')
p a(input), b(input)
