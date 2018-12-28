defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
    |> Enum.map(fn x ->
      [a, _, b, _, dist] = x |> String.split(" ")
      [{a, b, String.to_integer(dist)}, {b, a, String.to_integer(dist)}]
    end)
    |> List.flatten()
  end

  def permute([]), do: [[]]

  def permute(list) when is_list(list) do
    for x <- list, y <- permute(list -- [x]), do: [x | y]
  end

  def resolve(input) do
    distances = distances(input)

    cities(distances)
    |> permute
    |> Enum.map(&route_distance(&1, distances))
    |> Enum.min()
  end

  def distances(input) do
    input
    |> Enum.reduce(%{}, fn {a, b, d}, acc -> Map.put(acc, {a, b}, d) end)
  end

  def cities(input) do
    input
    |> Map.keys()
    |> Enum.map(&elem(&1, 0))
    |> Enum.uniq()
  end

  def route_distance([city | rest], distances) do
    route_distance(rest, distances, city, 0)
  end

  def route_distance([city | rest], distances, last, acc) do
    dist = Map.get(distances, {last, city})
    route_distance(rest, distances, city, dist + acc)
  end

  def route_distance([], _, _, acc) do
    acc
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
