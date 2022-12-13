# frozen_string_literal: true

require 'set'
def build(input)
  grid = {}
  cache = {}

  from = to = nil
  from_as = []
  input.each_with_index do |row, y|
    row.split('').each_with_index do |v, x|
      if v == 'S'
        from = [x, y]
        v = 'a'
      end
      if v == 'E'
        to = [x, y]
        v = 'z'
      end
      from_as << [x, y] if v == 'a'
      grid[[x, y]] = v.ord
    end
  end

  grid.each_key do |n|
    cache[n] = adj(grid, n)
  end

  [grid, cache, from, from_as, to]
end

def adj(grid, from)
  x, y = from
  [[x, y - 1], [x, y + 1], [x - 1, y], [x + 1, y]]
    .reject { |tx, ty| grid[[tx, ty]].nil? }
    .select { |tx, ty| grid[[tx, ty]] <= grid[[x, y]] + 1 }
end

def bfs(grid, from, to, cache: nil)
  queue = [[from]]
  visited = Set.new([from])

  while queue.size.positive?
    path = queue.shift
    node = path.last

    return path if node == to

    adj = cache.nil? ? adj(grid, node) : cache[node]
    adj.each do |n|
      next if visited.include? n

      visited << n
      queue << path + [n]
    end
  end

  []
end

def a(input)
  grid, cache, from, _from_as, to = build(input)
  bfs(grid, from, to, cache: cache).size - 1
end

def b(input)
  grid, cache, _from, from_as, to = build(input)
  from_as.map { |from| bfs(grid, from, to, cache: cache).size }.select(&:positive?).min - 1
end

input = File.read('input').split("\n")

p a(input), b(input)
