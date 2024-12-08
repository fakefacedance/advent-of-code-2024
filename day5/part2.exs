defmodule Sln do
  def part2() do
    File.read!("./input.txt")
    |> String.split("\n\n")
    |> then(fn [rules, updates] ->
      [
        String.split(rules, "\n", trim: true) |> parse_rules(),
        String.split(updates, "\n", trim: true) |> Enum.map(fn x -> String.split(x, ",") end)
      ]
    end)
    |> then(fn [rules, updates] -> [rules, get_invalid_updates(updates, rules)] end)
    |> then(fn [rules, updates] -> Enum.map(updates, &reorder(&1, rules)) end)
    |> Enum.map(&(Enum.at(&1, div(length(&1), 2)) |> String.to_integer()))
    |> Enum.reduce(fn mid_num, acc -> acc + mid_num end)
  end

  def parse_rules(rules, map \\ %{})
  def parse_rules([], map), do: map

  def parse_rules(rules, map) do
    [x, y] = String.split(hd(rules), "|")
    map = Map.put(map, y, [x | Map.get(map, y, [])])
    parse_rules(tl(rules), map)
  end

  def get_invalid_updates(updates, rules) do
    Enum.filter(updates, fn update -> !is_valid(Enum.reverse(update), rules) end)
  end

  def is_valid([_ | []], _), do: true

  def is_valid([number | rest], rules) do
    Map.has_key?(rules, number) && Enum.all?(rest, &Enum.member?(rules[number], &1)) &&
      is_valid(rest, rules)
  end

  def reorder(update, rules) do
    reorder_rec(Enum.reverse(update), rules)
  end

  defp reorder_rec(update, rules, index \\ 0)
  defp reorder_rec(update, _, index) when length(update) === index + 1, do: Enum.reverse(update)

  defp reorder_rec(update, rules, index) do
    current = Enum.at(update, index)

    case Enum.find_index(Enum.slice(update, index + 1, length(update) - index), fn number ->
           Enum.member?(rules[number] || [], current)
         end) do
      nil -> reorder_rec(update, rules, index + 1)
      i -> reorder_rec(push_to_start(update, i + 1 + index), rules, 0)
    end
  end

  defp push_to_start(list, index) do
    {value, new_list} = List.pop_at(list, index)
    [value | new_list]
  end
end

Sln.part2() |> IO.inspect(label: "Part 2")
