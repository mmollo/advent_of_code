input = File.read("./input").split.map &.to_i 


def a(input)
	count = 0
	input.each_with_index do |a,i|
		next if i.zero?
		count += 1 if a > input[i-1]
	end
	count
end

def b(input)
	count = 0
	input.each_with_index do |a,i|
		next if i < 2
		count += 1 if a > input[i-3]
	end
	count
end	

puts a input
puts b input
