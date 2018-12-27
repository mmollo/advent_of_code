defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
  end

  def resolve(input) do
    input
    |> Enum.map(&parse_instruction(&1))
    |> Enum.reduce(%{}, fn x, acc -> execute(x, acc) end)
  end

  defp execute([action, {xa, ya} = a, {xb, yb} = b], acc) do
    case action do
      "turn on" -> turn_on(a, b, acc)
      "turn off" -> turn_off(a, b, acc)
      "toggle" -> toggle(a, b, acc)
    end
  end

  def turn_on(a, b, acc) do
    get_ranges(a, b)
    |> Enum.reduce(acc, fn x, acc -> Map.update(acc, x, 1, fn z -> z + 1 end) end)
  end

  defp turn_off(a, b, acc) do
    get_ranges(a, b)
    |> Enum.reduce(acc, fn x, acc -> Map.update(acc, x, 0, fn z -> max(0, z - 1) end) end)
  end

  def toggle(a, b, acc) do
    get_ranges(a, b)
    |> Enum.reduce(acc, fn x, acc -> Map.update(acc, x, 2, fn z -> z + 2 end) end)
  end

  def get_ranges({xa, ya}, {xb, yb}) do
    for x <- xa..xb, y <- ya..yb, do: {x, y}
  end

  defp parse_instruction(str) when is_binary(str) do
    [_, action, xa, ya, xb, yb] =
      Regex.run(~r/([a-z ]+) ([\d]+),([\d]+) through ([\d]+),([\d]+)/, str)

    [
      action,
      {String.to_integer(xa), String.to_integer(ya)},
      {String.to_integer(xb), String.to_integer(yb)}
    ]
  end
end

A.create_input("input")
|> A.resolve()
|> Map.values()
|> Enum.sum()
|> IO.inspect()
