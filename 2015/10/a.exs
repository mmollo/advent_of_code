defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
  end

  def resolve(<<number, rest::binary>>) do
    # IO.puts "Number: #{<<number>>}, Rest: #{rest}"
    resolve(rest, number, 1, "")
  end

  defp resolve(<<number, rest::binary>>, last, count, acc) do
    # IO.puts "Number: #{<<number>>}, Rest: #{rest}, Last: #{<<last>>}, Count: #{count}, Acc: #{acc}"
    case last == number do
      true -> resolve(rest, number, count + 1, acc)
      false -> resolve(rest, number, 1, acc <> Integer.to_string(count) <> <<last>>)
    end
  end

  defp resolve(<<>>, last, count, acc) do
    acc <> "#{count}#{<<last>>}"
  end
end

input = A.create_input("input")

1..40
|> Enum.reduce(input, fn _, acc ->
  acc |> A.resolve()
end)
|> String.length()
|> IO.inspect()
