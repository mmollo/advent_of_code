# frozen_string_literal: true

# Too lazy to clean this mess

def input(file)
  input = File.read(file).split("\n").map { |r| r.split(' -> ').map { |s| s.split(',').map(&:to_i) } }
  grid = {}
  input.each do |l|
    from = l.shift
    while (to = l.shift)
      ax, ay = from
      tx, ty = to
      ([ax, tx].min..[ax, tx].max).each do |x|
        ([ay, ty].min..[ay, ty].max).each do |y|
          grid[[x, y]] = '#'
        end
      end
      from = to
    end
  end
  grid
end

def drop_a(grid, from = [500, 0])
  x, y = from

  until grid.key? [x, y + 1]
    y += 1
    return false if y > 300
  end

  return drop_a(grid, [x - 1, y + 1]) unless grid.key? [x - 1, y + 1]
  return drop_a(grid, [x + 1, y + 1]) unless grid.key? [x + 1, y + 1]

  grid [[x, y]] = 'o'

  true
end

def drop_b(grid, max = 10, from = [500, 0])
  return false if grid[[500, 0]] == 'o'

  x, y = from

  if y == max
    grid[[x, y]] = 'o'
    return true
  end

  y += 1 while (!grid.key? [x, y + 1]) && y < max

  if y == max
    grid[[x, y]] = 'o'
    return true
  end

  return drop_b(grid, max, [x - 1, y + 1]) unless grid.key? [x - 1, y + 1]
  return drop_b(grid, max, [x + 1, y + 1]) unless grid.key? [x + 1, y + 1]

  grid[[x, y]] = 'o'

  true
end

def a(grid)
  i = 0
  i += 1 while drop_a(grid)
  i
end

def b(grid)
  max = grid.keys.map(&:last).max + 1
  i = 0
  i += 1 while drop_b(grid, max)
  i
end

p a(input('input'))
p b(input('input'))
