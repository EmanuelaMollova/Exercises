class String
  def longest_sequence
    chunked = chars.chunk { |char| char }.sort_by { |item| item.last.size }
    chunked.select { |item| item.last.size == chunked.last.last.size }.map(&:first).uniq
  end
end
