defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_line/1)
    |> Enum.reduce(%{}, fn {guest1, guest2, points}, acc ->
      Map.put(acc, {guest1, guest2}, points)
    end)
  end

  def resolve(relations) do
    relations
    |> list_guests
    |> permutations
    |> Enum.map(fn x ->
      {x, happiness(x, relations)}
    end)
    |> Enum.max_by(fn {_, score} -> score end)
    |> elem(1)
  end

  defp happiness([guest1 | tail], relations) do
    guest2 = List.last(tail)

    points = Map.get(relations, {guest1, guest2})
    points2 = Map.get(relations, {guest2, guest1})
    happiness(tail, relations, guest1, points + points2)
  end

  defp happiness([guest2 | tail], relations, guest1, acc) do
    points = Map.get(relations, {guest1, guest2})
    points2 = Map.get(relations, {guest2, guest1})
    happiness(tail, relations, guest2, acc + points + points2)
  end

  defp happiness([], _, _, acc), do: acc

  defp list_guests(input) do
    input
    |> Enum.map(fn {{guest1, _}, _} -> guest1 end)
    |> Enum.uniq()
  end

  defp permutations([]), do: [[]]

  defp permutations(list) when is_list(list) do
    for x <- list, y <- permutations(list -- [x]), do: [x | y]
  end

  defp parse_line(line) do
    [_, guest1, action, amount, guest2] =
      Regex.run(
        ~r/([a-zA-Z]+) would (gain|lose) ([\d]+) happiness units by sitting next to ([a-zA-Z]+)./,
        line
      )

    amount =
      case action do
        "gain" -> String.to_integer(amount)
        "lose" -> String.to_integer(amount) * -1
      end

    {guest1, guest2, amount}
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
