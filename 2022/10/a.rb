# frozen_string_literal: true

class CPU
  def initialize
    @cycle = 0
    @register = 1
  end

  def noop(*) = tick

  def addx(val)
    2.times { tick }
    @register += val
  end

  def tick = @cycle += 1
end

class ACPU < CPU
  attr_reader :signals

  CYCLES = [20, 60, 100, 140, 180, 220].freeze

  def initialize
    super
    @signals = []
  end

  def tick
    super
    @signals << (@cycle * @register) if CYCLES.include? @cycle
  end
end

class BCPU < CPU
  CRT_WIDTH = 40

  def initialize
    super
    @crt = []
  end

  def tick
    super
    @crt << (sprite? ? '#' : '.')
  end

  def view
    @crt.each_slice(40).map(&:join).join("\n")
  end

  private

  def sprite?
    ((@cycle - 1) % CRT_WIDTH - @register).abs <= 1
  end
end

def run(input, klass)
  cpu = klass.new
  input.each do |l|
    op, n = l.split
    cpu.send(op, n&.to_i)
  end
  cpu
end

def a(input)
  run(input, ACPU).signals.sum
end

def b(input)
  run(input, BCPU).view
end

input = File.read('input').split("\n")

p a(input)
puts b(input)
