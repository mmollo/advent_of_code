input = File.read('sample').split('').cycle.each

def shapes
    shapes = []
    shapes << [[0,0], [1,0], [2,0], [3,0]]
    shapes << [[1,0], [0,1], [1,1], [2,1], [1,2]]
    shapes << [[2,0], [2,1], [0,2], [1,2], [2,2]]
    shapes << [[0,0], [0,1], [0,2], [0,3]]
    shapes << [[0,0], [1,0], [0,1], [1,1]]
    
    shapes.cycle.each
end

def left_edge(shape)
    shape.map { |x, y| x }.min
end

def bottom_edge(shape)
    shape.map { |x, y| y }.max
end

def down?(grid, shape)
end


def left?(grid, shape)
end

def right(grid, shape)
end


def a(input)
    shapes = shapes()
    0
end

def b(input)
    0
end

#p a(input), b(input)


bar = shapes.take(2).last
p left_edge(bar)
p bottom_edge(bar)

