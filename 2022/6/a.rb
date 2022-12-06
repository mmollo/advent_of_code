# frozen_string_literal: true

def decode(input, size)
  i = size
  while i < input.size
    break if input[i - size..i - 1].split('').uniq.size == size

    i += 1
  end
  i
end

%w[sample sample2 sample3 sample4 sample5 input].each do |file|
  input = File.read(file).strip
  p "#{file} #{decode(input, 4)} #{decode(input, 14)}"
end
