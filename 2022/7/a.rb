def build(input)
  d = { '' => 0 }
  p = ['']
  input.each do |l|
    next if l[0..3] == '$ ls'
    if l == '$ cd /' then p = ['']
    elsif l == '$ cd ..' then p.pop
    elsif l[0..3] == '$ cd' then p << l[5..]
    elsif l[0..2] == 'dir'  then d[(p + [l[4..]]).join('/')] = 0
    else p.size.times { |i|  d[p[..i].join('/')] += l.split.first.to_i } end
  end

  d
end

def a(input)
  input.values.filter { |s| s < 100_000 }.sum
end

def b(input)
  input.values.filter { |s| s >= input[''] - 40_000_000 }.min
end

input = build(File.read('input').split("\n"))
p a(input), b(input)
