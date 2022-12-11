# frozen_string_literal: true

input = File.read('input').split("\n\n").map { |m| m.split("\n") }

def build(input)
  input.map do |m|
    {
      items: m[1].split(': ')[1].split(',').map(&:to_i),
      operation: m[2].split('= ')[1],
      test: m[3].split.last.to_i,
      t: m[4].split.last.to_i,
      f: m[5].split.last.to_i,
      score: 0
    }
  end
end

def run(monkeys, rounds, relief)
  #lcm = monkeys.map { |m| m[:test] }.reduce(&:lcm)
  lcm = monkeys.map { |m| m[:test] }.reduce(&:*)

  rounds.times do
    monkeys.each do |monkey|
      items = monkey[:items]
      monkey[:items] = []
      items.each do |old|
        old = eval monkey[:operation]
        monkey[:score] += 1
        relief ? old /= 3 : old %= lcm
        to = (old % monkey[:test]).zero? ? monkey[:t] : monkey[:f]
        monkeys[to][:items] << old
      end
    end
  end

  monkeys.map { |m| m[:score] }.max(2).reduce(&:*)
end

def a(input) = run(build(input), 20, true)
def b(input) = run(build(input), 10_000, false)

p a(input), b(input)
