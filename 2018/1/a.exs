File.read!('input')
|> String.split(["\n", "\r"], trim: true)
|> Enum.map(fn v -> String.to_integer v end)
|> Enum.sum
|> IO.puts
