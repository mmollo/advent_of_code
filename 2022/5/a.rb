# frozen_string_literal: true

def crates_moves(input)
  state, moves = input.map { |b| b.split("\n") }
  state.pop

  crates = []
  state.each do |line|
    line.scan(/( {4}|[A-Z])/).flatten.each_with_index do |label, i|
      next if label == '    '

      crates[i] ||= []
      crates[i] << label
    end
  end

  moves = moves.map { |move| move.scan(/\d+/).map(&:to_i) }

  [crates, moves]
end

def a(input)
  crates, moves = crates_moves(input)
  moves.each do |n, f, t|
    n.times { crates[t - 1].prepend crates[f - 1].shift }
  end

  crates.map(&:shift).join
end

def b(input)
  crates, moves = crates_moves(input)
  moves.each do |n, f, t|
    crates[t - 1].prepend(*crates[f - 1].slice!(0, n))
  end
  crates.map(&:shift).join
end

input = File.read('input').split("\n\n")

p a(input), b(input)
