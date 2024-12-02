defmodule Solution do
  def get_distance(list1, list2) do
    Enum.zip(list1, list2)
    |> Enum.reduce(0, fn {left, right}, acc -> acc + abs(left - right) end)
  end

  def get_similarity_score(list1, list2) do
    freqs = Enum.frequencies(list2)
    Enum.reduce(list1, 0, fn item, acc -> acc + item * Map.get(freqs, item, 0) end)
  end
end

{left_list, right_list} =
  File.read!("./input.txt")
  |> String.split("\n", trim: true)
  |> Enum.map(fn pair -> String.split(pair) |> Enum.map(&String.to_integer/1) end)
  |> Enum.map(fn [a, b] -> {a, b} end)
  |> Enum.unzip()
  |> then(fn {left, right} -> {Enum.sort(left), Enum.sort(right)} end)

Solution.get_distance(left_list, right_list)
|> IO.inspect(label: "distance")

Solution.get_similarity_score(left_list, right_list)
|> IO.inspect(label: "silimarity score")
