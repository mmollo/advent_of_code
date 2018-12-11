defmodule A do
  def add_sleep(guard, amount) do
    Map.update(guard, :sleep, amount, &(&1 + amount))
  end

  def add_details(guard, details) do
    Map.update(guard, :details, details, fn d ->
      Map.merge(d, details, fn _k, a, b -> a + b end)
    end)
  end

  def parse(str) do
    Regex.named_captures(
      ~r/\[[0-9]+-[0-9]+-[0-9]+ [0-9]+:(?<min>[0-9]+)\] (?<action>[a-zA-Z]+) (#(?<id>[\d]+))?/,
      str
    )
  end

  def add_event(%{"action" => "Guard", "id" => id}, acc) do
    Map.put(acc, :id, String.to_integer(id))
  end

  def add_event(%{"action" => "falls", "min" => min}, acc) do
    Map.put(acc, :time, String.to_integer(min))
  end

  def add_event(%{"action" => "wakes", "min" => min}, acc) do
    min = String.to_integer(min)
    sleep_time = min - acc.time
    details = Map.new(acc.time..(min - 1), fn x -> {x, 1} end)

    guards =
      Map.update(acc.guards, acc.id, %{id: acc.id, sleep: sleep_time, details: details}, fn g ->
        add_sleep(g, sleep_time) |> add_details(details)
      end)

    Map.put(acc, :guards, guards)
  end

  def resolve(input) do
    input |> resolve(%{guards: %{}})
  end

  def resolve([head | tail], acc) do
    acc =
      head
      |> parse
      |> add_event(acc)

    resolve(tail, acc)
  end

  def resolve([], acc) do
    {id, {min, _}} =
      acc.guards
      |> Enum.map(fn {id, guard} ->
        {id, guard.details |> Enum.max_by(fn {_min, amount} -> amount end)}
      end)
      |> Enum.max_by(fn {_id, {_min, amount}} -> amount end)

    id * min
  end
end

File.read!("input")
|> String.split(["\r", "\n"], trim: true)
|> Enum.sort()
|> A.resolve()
|> IO.inspect()
