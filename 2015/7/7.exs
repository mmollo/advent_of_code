Code.require_file("a.exs")
Code.require_file("b.exs")

defmodule Day7 do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
    |> Enum.map(&parse_line(&1))
    |> Enum.reduce(%{}, fn {k, v}, acc -> Map.put(acc, k, v) end)
  end
end

input = Day7.create_input(input)
