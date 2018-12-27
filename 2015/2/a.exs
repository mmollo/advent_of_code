defmodule A do
  def resolve(input) when is_list(input) do
    input
    |> parse_input
    |> Enum.map(&calculate_surface(&1))
    |> Enum.sum()
  end

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
  end

  def parse_input(input) when is_list(input) do
    input
    |> Enum.map(&parse_dimensions(&1))
  end

  defp parse_dimensions(dimensions) when is_binary(dimensions) do
    dimensions
    |> String.split("x")
    |> Enum.map(&String.to_integer(&1))
  end

  defp calculate_surface([l, w, h] = dimensions) do
    2 * l * w + 2 * w * h + 2 * h * l + smallest_area(dimensions)
  end

  defp smallest_area(dimensions) when is_list(dimensions) do
    [a, b] =
      dimensions
      |> Enum.sort()
      |> Enum.take(2)

    a * b
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
