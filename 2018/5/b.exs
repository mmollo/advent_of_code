input =
  File.read!("input")
  |> String.trim()

defmodule B do
  # © José Valim
  # I just love how elegant and fast it is
  def react(polymer) when is_binary(polymer),
    do: react(polymer, [])

  def react(<<letter1, rest::binary>>, [letter2 | acc]) when abs(letter1 - letter2) == 32,
    do: react(rest, acc)

  def react(<<letter, rest::binary>>, acc),
    do: react(rest, [letter | acc])

  def react(<<>>, acc),
    do: acc |> Enum.count()

  def resolve(input) do
    ?a..?z
    |> Enum.map(fn l -> [<<l>>, <<l - 32>>] end)
    |> Enum.map(fn l -> String.replace(input, l, "") end)
    |> Enum.map(fn l -> react(l) end)
    |> Enum.min()
  end
end

input
|> B.resolve()
|> IO.inspect()
