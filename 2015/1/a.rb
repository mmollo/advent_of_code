input = File.read("#{__dir__}/input")
p input.count('(') - input.count(')')
