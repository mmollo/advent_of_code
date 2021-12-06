defmodule A do
  use GenServer

  def init(:ok) do
    {:ok, [nil, 0]}
  end

  def handle_cast({:add, value}, [last, count]) do
    count =
      if value > last do
        count + 1
      else
        count
      end

    {:noreply, [value, count]}
  end

  def handle_call(:get, _from, [_value, count]) do
    {:reply, count, [nil, 0]}
  end
end

{:ok, server} = GenServer.start_link(A, :ok)
{:ok, server2} = GenServer.start_link(A, :ok)

  File.read!('./input')
  |> String.split("\n", trim: true)
  |> Stream.map(&String.to_integer/1)
  |> Stream.each(fn x -> GenServer.cast(server, {:add, x}) end)
  |> Stream.each(fn x -> GenServer.cast(server2, {:add, x}) end)
  
  |> Enum.to_list
  
GenServer.call(server, :get)
|> IO.inspect()

GenServer.call(server2, :get)
|> IO.inspect()
