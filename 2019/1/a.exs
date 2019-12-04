defmodule A do
  defp mass2fuel(0, _), do: 0
  defp mass2fuel(x, false), do: max(0, Integer.floor_div(x, 3) - 2)

  defp mass2fuel(x, true) do
    fuel = mass2fuel(x, false)
    fuel + mass2fuel(fuel, true)
  end

  def resolve(input, full \\ false) when is_list(input) do
    input
    |> Enum.map(&mass2fuel(&1, full))
    |> Enum.sum()
  end
end

input =
  File.read!('./input')
  |> String.split("\n", trim: true)
  |> Enum.map(&String.to_integer/1)

input
|> A.resolve()
|> IO.puts()

input
|> A.resolve(true)
|> IO.puts()
