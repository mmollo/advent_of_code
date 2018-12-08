input =
  File.read!("input")
  |> String.split(["\r", "\n"], trim: true)

defmodule A do
  defp parse(str) do
    Regex.named_captures(~r/^#[0-9]+ @ (?<x>[0-9]+),(?<y>[0-9]+): (?<w>[0-9]+)x(?<h>[0-9]+)/, str)
  end

  defp clean(fabric) do
    %{
      x: String.to_integer(fabric["x"]),
      y: String.to_integer(fabric["y"]),
      w: String.to_integer(fabric["w"]),
      h: String.to_integer(fabric["h"])
    }
  end

  defp append(fabric, claim) do
    to_x = claim.x + claim.w - 1
    to_y = claim.y + claim.h - 1

    for(x <- claim.x..to_x, y <- claim.y..to_y, do: "#{x}x#{y}")
    |> Enum.reduce(fabric, fn x, acc -> Map.update(acc, x, 1, &(&1 + 1)) end)
  end

  def main([head | tail], fabric) do
    claim = head |> parse |> clean
    main(tail, append(fabric, claim))
  end

  def main([], fabric) do
    fabric
    |> Map.values()
    |> Enum.filter(fn x -> x > 1 end)
    |> Enum.count()
  end
end

input
|> A.main(%{})
|> IO.inspect()
