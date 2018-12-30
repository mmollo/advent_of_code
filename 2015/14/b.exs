defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_reindeer/1)
  end

  def resolve(reindeers) do
    scores =
      reindeers
      |> Enum.reduce(%{}, fn x, acc -> Map.put(acc, elem(x, 0), 0) end)

    1..2503
    |> Enum.reduce(scores, fn i, acc ->
      new_scores =
        run_all(reindeers, i)
        |> get_max

      Map.merge(acc, new_scores, fn _k, old, new -> old + new end)
    end)
    |> Enum.max_by(fn {_name, score} -> score end)
    |> elem(1)
  end

  defp get_max(scores) do
    {_, max} = Enum.max_by(scores, fn {_, score} -> score end)

    Enum.reduce(scores, %{}, fn {name, score}, acc ->
      score = if score == max, do: 1, else: 0
      Map.put(acc, name, score)
    end)
  end

  defp run_all(reindeers, seconds) do
    reindeers
    |> Enum.map(fn {name, speed, duration, rest} ->
      {name, run(speed, duration, rest, seconds)}
    end)
  end

  defp run(speed, duration, rest, seconds) do
    full = div(seconds, duration + rest) * duration
    partial = min(duration, rem(seconds, duration + rest))
    speed * (full + partial)
  end

  defp parse_reindeer(str) do
    [_, name, speed, duration, rest] =
      Regex.run(
        ~r/(^[A-Za-z]+) can fly ([\d]+) km\/s for ([\d]+) seconds, but then must rest for ([\d]+) seconds/,
        str
      )

    {name, String.to_integer(speed), String.to_integer(duration), String.to_integer(rest)}
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
