# frozen_string_literal: true

require 'matrix'

input = File.read('input').split("\n").map { |l| l.split('').map(&:to_i) }
m = Matrix[*input]

def pat(m, x, y)
  w = m.row_size - 1
  col = m.column(y)
  row = m.row(x)

  u = x.zero? ? [] : col[..x - 1].reverse
  d = x == w ? [] : col[x + 1..]
  l = y.zero? ? [] : row[..y - 1].reverse
  r = y == w ? [] : row[y + 1..]

  [u, d, l, r]
end

def edg?(m, x, y)
  ([0, m.row_size - 1] & [x, y]).any?
end

def vis?(m, x, y, n)
  edg?(m, x, y) || pat(m, x, y).any? { |s| s.none? { |h| h >= n } }
end

def a(m)
  m.each_with_index.map.count { |n, x, y| vis? m, x, y, n }
end

def sco(a, n)
  s = a.take_while { |h| h < n }.count
  a.size == s ? s : s + 1
end

def b(m)
  m.each_with_index.map { |n, x, y| pat(m, x, y).map { |a| sco(a, n) }.reduce(&:*) }.max
end
p a(m), b(m)
