# frozen_string_literal: true

def input
  File.read('input')
      .split("\n\n")
      .map(&:split)
      .map { |elve| elve.map(&:to_i).sum }
end

p input.max

p input.max(3).sum
