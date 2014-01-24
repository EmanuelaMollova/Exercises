def zig_zag(n)
  matrix = 1.upto(n * n).each_slice(n).to_a
  0.upto(n.pred).select { |index| index.odd? }. map { |index| matrix[index].reverse! }
  matrix
end
