interface Column<T> {
  header: string;
  key: keyof T | string;
  render?: (item: T) => React.ReactNode; 
}

interface Props<T> {
    columns: Column<T>[];
    data: T[];
    emptyMessage?: string;
}

export const DataTable = <T extends { id: string | number }>({ 
    columns, 
    data =[], 
    emptyMessage = "No hay registros disponibles." 
}: Props<T>) => {
    return (
        <div className="overflow-x-auto border rounded-lg">
            <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                <tr>
                    {columns.map((col, index) => (
                    <th key={index} className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        {col.header}
                    </th>
                    ))}
                </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                {data.length === 0 ? (
                    <tr>
                    <td colSpan={columns.length} className="px-4 py-4 text-sm text-gray-500 text-center">
                        {emptyMessage}
                    </td>
                    </tr>
                ) : (
                    data.map((item) => (
                    <tr key={item.id}>
                        {columns.map((col, index) => (
                        <td key={index} className="px-4 py-4 text-sm text-gray-500">
                            {col.render ? col.render(item) : (item[col.key as keyof T] as React.ReactNode)}
                        </td>
                        ))}
                    </tr>
                    ))
                )}
                </tbody>
            </table>
        </div>
    );
};