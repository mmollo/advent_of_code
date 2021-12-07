input = File.read('./input').split(',').map(&:to_i).sort!

def a(input)
  k = input[input.size / 2]
  input.map { |i| (i - k).abs }.sum
end

def b(input)
  min, max = input.minmax
  (min..max).map do |n|
    input.map do |i|
      k = (i - n).abs
      (k * (k + 1)) / 2
    end.sum
  end.min
end

p a input
p b input
