defmodule A do
  def create_input(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_line/1)
  end

  def resolve(triangles) when is_list(triangles) do
    triangles
    |> Enum.filter(&is_triangle/1)
    |> Enum.count()
  end

  defp is_triangle([a, b, c]) do
    a + b > c
  end

  defp parse_line(line) do
    Regex.run(~r/([\d]+) +([\d]+) +([\d]+)/, line, capture: :all_but_first)
    |> Enum.map(&String.to_integer/1)
    |> Enum.sort()
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
