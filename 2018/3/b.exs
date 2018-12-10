defmodule B do
  def parse(str) do
    Regex.named_captures(
      ~r/^#(?<id>[0-9]+) @ (?<x>[0-9]+),(?<y>[0-9]+): (?<w>[0-9]+)x(?<h>[0-9]+)/,
      str
    )
  end

  def clean(fabric) do
    %{
      id: String.to_integer(fabric["id"]),
      x: String.to_integer(fabric["x"]),
      y: String.to_integer(fabric["y"]),
      w: String.to_integer(fabric["w"]),
      h: String.to_integer(fabric["h"])
    }
  end

  defp overlap(a, b) do
    !(a.x + a.w <= b.x || a.x >= b.x + b.w || a.y + a.h <= b.y || a.y >= b.y + b.h)
  end

  def resolve([head | tail]) do
    case Enum.any?(tail, fn r -> overlap(head, r) end) do
      true -> resolve(tail ++ [head])
      _ -> head.id
    end
  end
end


File.read!("input")
  |> String.split(["\r", "\n"], trim: true)
  |> Enum.map(&B.parse/1)
  |> Enum.map(&B.clean/1)
  |> B.resolve
  |> IO.puts
