input = File.read!("input")
|> String.split(["\r", "\n"], trim: true)


defmodule A do
    def main(str) do
        values = String.split(str, "", trim: true)
        |> Enum.reduce(%{}, fn e, acc -> Map.update(acc, e, 1, &(&1 + 1)) end)
        |> Map.values
        |> MapSet.new


        {MapSet.member?(values, 2), MapSet.member?(values,3)}
    end
end

output = Enum.reduce(input, %{2 => 0, 3 => 0}, fn str, acc ->
    IO.inspect [str, A.main(str)]
    {d, t} =  A.main(str)
    acc = if d do
        Map.update(acc, 2, 1, &(&1 + 1))
    else
        acc
    end
    acc = if t do
        Map.update(acc, 3, 1, &(&1 + 1))
    else
        acc
    end
    acc
end)


output |> Map.values
|> Enum.reduce(1, fn e, acc ->   acc * e end)
|> IO.inspect

